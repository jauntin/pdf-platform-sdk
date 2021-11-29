<?php

namespace Jauntin\PdfPlatformSdk\Template;

use Jauntin\PdfPlatformSdk\Request;

class CreateTemplateRequest extends Request
{
    protected string $method = 'POST';
    protected string $path = '/api/v1/templates';

    /**
     * @param CreateTemplateRequestData $data
     * @return CreateTemplateResponseData
     */
    public function request($data)
    {
        return new CreateTemplateResponseData($this->clientRequest($data->toArray()));
    }
}
