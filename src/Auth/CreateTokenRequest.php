<?php

namespace Jauntin\PdfPlatformSdk\Auth;

use Jauntin\PdfPlatformSdk\Exceptions\FailedRequestException;
use Jauntin\PdfPlatformSdk\Exceptions\InvalidInputException;
use Jauntin\PdfPlatformSdk\Request;
use JsonException;
use ReflectionException;

class CreateTokenRequest extends Request
{
    protected string $method = 'POST';
    protected string $path = '/oauth/token';

    /**
     * @param CreateTokenRequestData $data
     *
     * @return CreateTokenResponseData
     *
     * @throws InvalidInputException
     * @throws ReflectionException
     * @throws FailedRequestException
     * @throws JsonException
     */
    public function request($data): CreateTokenResponseData
    {
        return new CreateTokenResponseData($this->clientRequest($data->toArray()));
    }
}
