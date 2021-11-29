<?php

namespace Jauntin\PdfPlatformSdk\Document;

use Jauntin\PdfPlatformSdk\Request;

class GetDocumentRequest extends Request
{
    protected string $method = 'GET';
    protected string $path = '/api/v1/documents/%s';

    /**
     * @param GetDocumentRequestData $data
     * @return GetDocumentResponseData
     */
    public function request($data)
    {
        $this->path = sprintf($this->path, $data->id);
        return new GetDocumentResponseData($this->clientRequest($data->toArray()));
    }
}
