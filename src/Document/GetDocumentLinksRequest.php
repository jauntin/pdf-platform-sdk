<?php

namespace Jauntin\PdfPlatformSdk\Document;

use Jauntin\PdfPlatformSdk\Request;

class GetDocumentLinksRequest extends Request
{
    protected string $method = 'GET';
    protected string $path = '/api/v1/documents/%s/links';

    public function request(array $data): array
    {
        $this->path = sprintf($this->path, $data['id']);
        return parent::request($data);
    }
}
