<?php

namespace Jauntin\PdfPlatformSdk\Auth;

use Jauntin\PdfPlatformSdk\RequestData;

class CreateTokenRequestData extends RequestData
{
    public string $grantType;

    public string $clientId;

    public string $clientSecret;
}
