<?php

namespace Jauntin\PdfPlatformSdk\Tests\Unit;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Jauntin\PdfPlatformSdk\Client;
use Jauntin\PdfPlatformSdk\ClientParameters;
use Jauntin\PdfPlatformSdk\Exceptions\FailedRequestException;
use Jauntin\PdfPlatformSdk\Tests\TestCase;

class ClientTest extends TestCase
{
    private const LOCATION = 'https://pdf.test';

    private function client(): Client
    {
        return new Client(new ClientParameters([
            'location' => self::LOCATION,
            'clientId' => 'test-client',
            'clientSecret' => 'test-secret',
        ]));
    }

    /**
     * @param  array<int,int>  $dataStatuses  successive HTTP statuses for the data endpoint
     */
    private function fakeHttp(array $dataStatuses = [200], string $firstToken = 'tok-1', string $secondToken = 'tok-2'): void
    {
        $data = Http::sequence();
        foreach ($dataStatuses as $status) {
            $data->push(['ok' => $status < 400], $status);
        }

        Http::fake([
            self::LOCATION.'/oauth/token' => Http::sequence()
                ->push(['access_token' => $firstToken, 'token_type' => 'Bearer', 'expires_in' => 3600])
                ->push(['access_token' => $secondToken, 'token_type' => 'Bearer', 'expires_in' => 3600]),
            self::LOCATION.'/api/v1/documents' => $data,
        ]);
    }

    protected function setUp(): void
    {
        parent::setUp();
        Cache::flush();
    }

    public function test_it_does_not_authenticate_on_construction(): void
    {
        $this->fakeHttp();

        $this->client();

        Http::assertNothingSent();
    }

    public function test_it_authenticates_lazily_before_the_first_request(): void
    {
        $this->fakeHttp();

        $response = $this->client()->request('POST', '/api/v1/documents', ['a' => 1]);

        $this->assertSame(['ok' => true], $response);

        // Token fetched first, carrying no bearer; data request carries the token.
        Http::assertSentInOrder([
            fn ($request) => $request->url() === self::LOCATION.'/oauth/token'
                && ! $request->hasHeader('Authorization'),
            fn ($request) => $request->url() === self::LOCATION.'/api/v1/documents'
                && $request->hasHeader('Authorization', 'Bearer tok-1'),
        ]);
    }

    public function test_it_reuses_a_cached_token_across_requests(): void
    {
        $this->fakeHttp([200, 200]);

        $client = $this->client();
        $client->request('POST', '/api/v1/documents', []);
        $client->request('POST', '/api/v1/documents', []);

        // Only one token fetch despite two data requests.
        Http::assertSentCount(3);
        $this->assertSame('tok-1', Cache::get('pdf_platform_access_token'));
    }

    public function test_it_reauthenticates_once_and_retries_on_401(): void
    {
        $this->fakeHttp([401, 200]);

        $response = $this->client()->request('POST', '/api/v1/documents', []);

        $this->assertSame(['ok' => true], $response);

        // token(tok-1) -> data(401) -> token(tok-2) -> data(200, tok-2)
        Http::assertSentCount(4);
        Http::assertSent(fn ($request) => $request->url() === self::LOCATION.'/api/v1/documents'
            && $request->hasHeader('Authorization', 'Bearer tok-2'));
        $this->assertSame('tok-2', Cache::get('pdf_platform_access_token'));
    }

    public function test_it_does_not_retry_more_than_once_on_repeated_401(): void
    {
        $this->fakeHttp([401, 401]);

        try {
            $this->client()->request('POST', '/api/v1/documents', []);
            $this->fail('Expected FailedRequestException');
        } catch (FailedRequestException $e) {
            $this->assertSame(401, $e->getCode());
        }

        // token -> data(401) -> token -> data(401), then give up.
        Http::assertSentCount(4);
    }

    public function test_failed_request_exception_carries_the_status_code(): void
    {
        $this->fakeHttp([500]);

        try {
            $this->client()->request('POST', '/api/v1/documents', []);
            $this->fail('Expected FailedRequestException');
        } catch (FailedRequestException $e) {
            $this->assertSame(500, $e->getCode());
        }
    }

    public function test_a_concurrently_published_token_is_reused_instead_of_refetched(): void
    {
        $this->fakeHttp();

        // Simulate another process having already published a valid token.
        Cache::put('pdf_platform_access_token', 'from-other-process', 3600);

        $this->client()->request('POST', '/api/v1/documents', []);

        // No token fetch happened; the cached token was used directly.
        Http::assertSent(fn ($request) => $request->url() === self::LOCATION.'/api/v1/documents'
            && $request->hasHeader('Authorization', 'Bearer from-other-process'));
        Http::assertNotSent(fn ($request) => $request->url() === self::LOCATION.'/oauth/token');
    }
}
