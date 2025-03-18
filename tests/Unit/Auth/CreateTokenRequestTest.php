<?php

namespace Jauntin\PdfPlatformSdk\Tests\Unit\Auth;

use Jauntin\PdfPlatformSdk\Auth\CreateTokenRequest;
use Jauntin\PdfPlatformSdk\Auth\CreateTokenRequestData;
use Jauntin\PdfPlatformSdk\Auth\CreateTokenResponseData;
use Jauntin\PdfPlatformSdk\Client;
use Jauntin\PdfPlatformSdk\Tests\TestCase;
use Mockery;

class CreateTokenRequestTest extends TestCase
{
    private CreateTokenRequest $request;

    private Client $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = Mockery::mock(Client::class);
        $this->request = new CreateTokenRequest($this->client);
    }

    public function test_it_can_create_a_token(): void
    {
        $requestData = new CreateTokenRequestData([
            'client_id' => 'test-client',
            'client_secret' => 'test-secret',
            'grant_type' => 'client_credentials',
        ]);

        $expectedResponse = [
            'access_token' => 'test-token',
            'token_type' => 'Bearer',
            'expires_in' => 3600,
        ];

        $this->client
            ->shouldReceive('request')
            ->once()
            ->with('POST', '/oauth/token', $requestData->toArray())
            ->andReturn($expectedResponse);

        $response = $this->request->request($requestData);

        $this->assertInstanceOf(CreateTokenResponseData::class, $response);
        $this->assertEquals('test-token', $response->accessToken);
        $this->assertEquals('Bearer', $response->tokenType);
        $this->assertEquals(3600, $response->expiresIn);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
