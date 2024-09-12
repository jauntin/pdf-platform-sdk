<?php

namespace Jauntin\PdfPlatformSdk;

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

    public function __construct(ClientParameters $clientParameters)
    {
        $this->clientParameters = $clientParameters;
        $this->authenticate();
    }

    /**
     * @param  array<mixed>  $data
     * @return array<mixed>
     *
     * @throws FailedRequestException
     */
    public function request(string $method, string $path, array $data): array
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
            $response = $request->send($method, $this->clientParameters->location.$path);
        } catch (\Exception $e) {
            throw new FailedRequestException('Unable to complete request', 0, $e);
        }
        if ($response->failed()) {
            throw new FailedRequestException('Unable to complete request', 0, $response->toException());
        }

        return $response->json();
    }

    private function authenticate(): void
    {
        if (! Cache::get($this->accessTokenCacheKey)) {
            /** @var CreateTokenRequest */
            $auth = resolve(CreateTokenRequest::class, ['client' => $this]);

            $createTokenRequestData = new CreateTokenRequestData;
            $createTokenRequestData->grantType = 'client_credentials';
            $createTokenRequestData->clientId = $this->clientParameters->clientId;
            $createTokenRequestData->clientSecret = $this->clientParameters->clientSecret;

            $response = $auth->request($createTokenRequestData);
            Cache::put($this->accessTokenCacheKey, $response->accessToken, $response->expiresIn - $this->accessTokenExpiryBufferPeriod);
        }
        $this->accessToken = Cache::get($this->accessTokenCacheKey);
    }
}
