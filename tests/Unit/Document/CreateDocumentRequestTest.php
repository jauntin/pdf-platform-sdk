<?php

namespace Jauntin\PdfPlatformSdk\Tests\Unit\Document;

use Jauntin\PdfPlatformSdk\Client;
use Jauntin\PdfPlatformSdk\Document\CreateDocumentRequest;
use Jauntin\PdfPlatformSdk\Document\CreateDocumentRequestData;
use Jauntin\PdfPlatformSdk\Document\CreateDocumentResponseData;
use Jauntin\PdfPlatformSdk\Tests\TestCase;
use Mockery;
use Mockery\MockInterface;

class CreateDocumentRequestTest extends TestCase
{
    private CreateDocumentRequest $request;

    private Client&MockInterface $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = Mockery::mock(Client::class);
        $this->request = new CreateDocumentRequest($this->client);
    }

    public function test_it_can_create_a_document(): void
    {
        $requestData = new CreateDocumentRequestData([
            'template_id' => 'test-template',
            'data_placements' => [
                'name' => 'Test Document',
                'content' => 'Test Content',
            ],
        ]);

        $expectedResponse = [
            'id' => 'test-doc-id',
            'status' => CreateDocumentRequest::STATUS_PENDING,
        ];

        $this->client
            ->shouldReceive('request')
            ->once()
            ->with('POST', '/api/v1/documents', $requestData->toArray())
            ->andReturn($expectedResponse);

        $response = $this->request->request($requestData);

        $this->assertInstanceOf(CreateDocumentResponseData::class, $response);
        $this->assertEquals('test-doc-id', $response->id);
        $this->assertEquals(CreateDocumentRequest::STATUS_PENDING, $response->status);
        // $this->assertEquals('2024-03-18T00:00:00Z', $response->createdAt);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
