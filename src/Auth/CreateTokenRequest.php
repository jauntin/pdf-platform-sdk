<?php

namespace Jauntin\PdfPlatformSdk\Auth;

use Jauntin\PdfPlatformSdk\Request;

class CreateTokenRequest extends Request
{
    protected string $method = 'POST';
    protected string $path = '/oauth/token';

    /**
     * @param CreateTokenRequestData $data
     * @return CreateTokenResponseData
     */
    public function request($data)
    {
        return new CreateTokenResponseData($this->clientRequest($data->toArray()));
    }
}
