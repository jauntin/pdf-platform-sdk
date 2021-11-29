<?php

namespace Jauntin\PdfPlatformSdk\Document;

use Jauntin\PdfPlatformSdk\Request;

class GetDocumentLinksRequest extends Request
{
    protected string $method = 'GET';
    protected string $path = '/api/v1/documents/%s/links';

    /**
     * @param GetDocumentLinksRequestData $data
     * @return GetDocumentLinksResponseData
     */
    public function request($data)
    {
        $this->path = sprintf($this->path, $data->id);
        return new GetDocumentLinksResponseData($this->clientRequest($data->toArray()));
    }
}
