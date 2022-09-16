<?php

namespace Jauntin\PdfPlatformSdk\Document;

use Jauntin\PdfPlatformSdk\Exceptions\FailedRequestException;
use Jauntin\PdfPlatformSdk\Exceptions\InvalidInputException;
use Jauntin\PdfPlatformSdk\Request;
use JsonException;
use ReflectionException;

class GetDocumentRequest extends Request
{
    protected string $method = 'GET';
    protected string $path = '/api/v1/documents/%s';

    /**
     * @param GetDocumentRequestData $data
     *
     * @return GetDocumentResponseData
     *
     * @throws FailedRequestException
     * @throws InvalidInputException
     * @throws JsonException
     * @throws ReflectionException
     */
    public function request($data): GetDocumentResponseData
    {
        $this->path = sprintf($this->path, $data->id);
        return new GetDocumentResponseData($this->clientRequest($data->toArray()));
    }
}
