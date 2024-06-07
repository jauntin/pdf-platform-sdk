<?php

namespace Jauntin\PdfPlatformSdk\Document;

use Jauntin\PdfPlatformSdk\Exceptions\FailedRequestException;
use Jauntin\PdfPlatformSdk\Exceptions\InvalidInputException;
use Jauntin\PdfPlatformSdk\Request;
use JsonException;
use ReflectionException;

class GetDocumentLinksRequest extends Request
{
    protected string $method = 'GET';

    protected string $path = '/api/v1/documents/%s/links';

    /**
     * @param  GetDocumentLinksRequestData  $data
     *
     * @throws FailedRequestException
     * @throws InvalidInputException
     * @throws JsonException
     * @throws ReflectionException
     */
    public function request($data): GetDocumentLinksResponseData
    {
        $this->path = sprintf($this->path, $data->id);

        return new GetDocumentLinksResponseData($this->clientRequest($data->toArray()));
    }
}
