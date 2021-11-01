<?php

namespace Jauntin\PdfPlatformSdk\Document;

use Jauntin\PdfPlatformSdk\Request;

class GetDocumentRequest extends Request
{
    protected string $method = 'GET';
    protected string $path = '/api/v1/documents/%s';

    public function request(array $data): array
    {
        $this->path = sprintf($this->path, $data['id']);
        return parent::request($data);
    }
}
