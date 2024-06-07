<?php

namespace Jauntin\PdfPlatformSdk\Auth;

use Jauntin\PdfPlatformSdk\ResponseData;

class CreateTokenResponseData extends ResponseData
{
    public string $tokenType;

    public int $expiresIn;

    public string $accessToken;
}
