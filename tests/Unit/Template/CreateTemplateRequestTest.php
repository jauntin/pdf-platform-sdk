<?php

namespace Jauntin\PdfPlatformSdk\Tests\Unit\Template;

use Jauntin\PdfPlatformSdk\Client;
use Jauntin\PdfPlatformSdk\Template\CreateTemplateRequest;
use Jauntin\PdfPlatformSdk\Template\CreateTemplateRequestData;
use Jauntin\PdfPlatformSdk\Template\CreateTemplateResponseData;
use Jauntin\PdfPlatformSdk\Tests\TestCase;
use Mockery;
use Mockery\MockInterface;

class CreateTemplateRequestTest extends TestCase
{
    private CreateTemplateRequest $request;

    private Client&MockInterface $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = Mockery::mock(Client::class);
        $this->request = new CreateTemplateRequest($this->client);
    }

    public function test_it_can_create_a_template(): void
    {
        $requestData = new CreateTemplateRequestData([
            'id' => 'test-template-id',
            'modules' => [
                'name' => 'Test Template',
            ],
        ]);

        $expectedResponse = [
            'id' => 'test-template-id',
            'modules' => [
                'name' => 'Test Template',
            ],
        ];

        $this->client
            ->shouldReceive('request')
            ->once()
            ->with('POST', '/api/v1/templates', $requestData->toArray())
            ->andReturn($expectedResponse);

        $response = $this->request->request($requestData);

        $this->assertInstanceOf(CreateTemplateResponseData::class, $response);
        $this->assertEquals('test-template-id', $response->id);
        $this->assertEquals('Test Template', $response->modules['name']);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
