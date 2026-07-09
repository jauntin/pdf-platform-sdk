<?php

namespace Jauntin\PdfPlatformSdk;

use Illuminate\Contracts\Cache\LockTimeoutException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Jauntin\PdfPlatformSdk\Auth\CreateTokenRequest;
use Jauntin\PdfPlatformSdk\Auth\CreateTokenRequestData;
use Jauntin\PdfPlatformSdk\Exceptions\FailedRequestException;

class Client
{
    private ClientParameters $clientParameters;

    private string $accessToken = '';

    private string $accessTokenCacheKey = 'pdf_platform_access_token';

    private int $accessTokenExpiryBufferPeriod = 240;

    /**
     * Safety TTL after which the auth lock auto-releases, in case a holder dies
     * mid-fetch. Must comfortably exceed a token request round-trip.
     */
    private int $authLockTtl = 15;

    /**
     * How long a request will wait to acquire the auth lock before giving up.
     */
    private int $authLockWait = 10;

    /**
     * Guards against recursion: the token request itself flows through
     * request()/send(), and must not trigger (re)authentication.
     */
    private bool $authenticating = false;

    public function __construct(ClientParameters $clientParameters)
    {
        $this->clientParameters = $clientParameters;
    }

    /**
     * @param  array<mixed>  $data
     * @return array<mixed>
     *
     * @throws FailedRequestException
     */
    public function request(string $method, string $path, array $data): array
    {
        // Authenticate lazily, only when an authenticated request is actually made.
        if (! $this->authenticating && ! $this->accessToken) {
            $this->authenticate();
        }

        $response = $this->send($method, $path, $data);

        // If the token was rejected (expired/revoked out from under us),
        // authenticate once more and retry the request a single time.
        if (! $this->authenticating && $response->status() === 401) {
            $this->authenticate(force: true);
            $response = $this->send($method, $path, $data);
        }

        if ($response->failed()) {
            throw new FailedRequestException('Unable to complete request', $response->status(), $response->toException());
        }

        return $response->json() ?? [];
    }

    /**
     * @param  array<mixed>  $data
     *
     * @throws FailedRequestException
     */
    private function send(string $method, string $path, array $data): Response
    {
        $request = Http::asJson()->acceptJson();
        if ($this->accessToken) {
            $request->withToken($this->accessToken);
        }
        if (
            $data
            &&
            ($json = json_encode($data, JSON_THROW_ON_ERROR | JSON_INVALID_UTF8_IGNORE))
        ) {
            $request->bodyFormat('json');
            $request->withBody($json, 'application/json');
        }
        try {
            return $request->send($method, $this->clientParameters->location.$path);
        } catch (\Exception $e) {
            throw new FailedRequestException('Unable to complete request', 0, $e);
        }
    }

    /**
     * Ensure a valid access token is loaded, fetching a fresh one if needed.
     *
     * Under concurrency, a cross-process lock ensures only one caller hits the
     * token endpoint; everyone else waits and reuses the token it publishes.
     *
     * @throws FailedRequestException
     */
    private function authenticate(bool $force = false): void
    {
        // Fast path: a cached token is good enough unless we're forcing a refresh
        // because the current one was just rejected.
        if (! $force && $token = Cache::get($this->accessTokenCacheKey)) {
            $this->accessToken = $token;

            return;
        }

        // The token we believe to be stale. Used inside the lock to tell whether
        // another process has already refreshed it while we were waiting.
        $staleToken = $force ? $this->accessToken : null;

        try {
            $this->accessToken = Cache::lock($this->accessTokenCacheKey.'.lock', $this->authLockTtl)
                ->block($this->authLockWait, function () use ($staleToken) {
                    // Re-check under the lock: whoever held it before us may have
                    // already published a fresh token, so avoid a redundant fetch.
                    $token = Cache::get($this->accessTokenCacheKey);
                    if ($token && $token !== $staleToken) {
                        return $token;
                    }

                    return $this->requestToken();
                });
        } catch (LockTimeoutException $e) {
            throw new FailedRequestException('Unable to acquire authentication lock', 0, $e);
        }
    }

    /**
     * Hit the token endpoint, cache the result, and return the new access token.
     *
     * @throws FailedRequestException
     */
    private function requestToken(): string
    {
        $this->authenticating = true;
        try {
            /** @var CreateTokenRequest */
            $auth = resolve(CreateTokenRequest::class, ['client' => $this]);

            $createTokenRequestData = new CreateTokenRequestData;
            $createTokenRequestData->grantType = 'client_credentials';
            $createTokenRequestData->clientId = $this->clientParameters->clientId;
            $createTokenRequestData->clientSecret = $this->clientParameters->clientSecret;

            $response = $auth->request($createTokenRequestData);
        } finally {
            $this->authenticating = false;
        }

        Cache::put(
            $this->accessTokenCacheKey,
            $response->accessToken,
            max(0, $response->expiresIn - $this->accessTokenExpiryBufferPeriod)
        );

        return $response->accessToken;
    }
}
