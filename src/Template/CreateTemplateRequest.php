<?php

namespace Jauntin\PdfPlatformSdk\Template;

use Jauntin\PdfPlatformSdk\Exceptions\FailedRequestException;
use Jauntin\PdfPlatformSdk\Exceptions\InvalidInputException;
use Jauntin\PdfPlatformSdk\Request;
use ReflectionException;

class CreateTemplateRequest extends Request
{
    protected string $method = 'POST';

    protected string $path = '/api/v1/templates';

    /**
     * @param  CreateTemplateRequestData  $data
     *
     * @throws InvalidInputException
     * @throws ReflectionException
     * @throws FailedRequestException
     */
    public function request($data): CreateTemplateResponseData
    {
        return new CreateTemplateResponseData($this->clientRequest($data->toArray()));
    }
}
