<?php

namespace Jauntin\PdfPlatformSdk\Document;

use Jauntin\PdfPlatformSdk\Exceptions\FailedRequestException;
use Jauntin\PdfPlatformSdk\Exceptions\InvalidInputException;
use Jauntin\PdfPlatformSdk\Request;
use ReflectionException;

class CreateDocumentRequest extends Request
{
    protected string $method = 'POST';

    protected string $path = '/api/v1/documents';

    public const STATUS_PENDING = 'pending';

    public const STATUS_COMPLETED = 'completed';

    public const STATUS_FAILED = 'failed';

    /**
     * @param  CreateDocumentRequestData  $data
     *
     * @throws InvalidInputException
     * @throws ReflectionException
     * @throws FailedRequestException
     */
    public function request($data): CreateDocumentResponseData
    {
        return new CreateDocumentResponseData($this->clientRequest($data->toArray()));
    }
}
