<?php

namespace Jauntin\PdfPlatformSdk\Document;

use Jauntin\PdfPlatformSdk\Request;

class CreateDocumentRequest extends Request
{
    protected string $method = 'POST';
    protected string $path = '/api/v1/documents';

    public const STATUS_PENDING = 'pending';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_FAILED = 'failed';

    /**
     * @param CreateDocumentRequestData $data
     * @return CreateDocumentResponseData
     */
    public function request($data)
    {
        return new CreateDocumentResponseData($this->clientRequest($data->toArray()));
    }
}
