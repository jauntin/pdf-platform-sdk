<?php

namespace Jauntin\PdfPlatformSdk\Document;

use Jauntin\PdfPlatformSdk\ResponseData;

class GetDocumentLinksResponseData extends ResponseData
{
    public string $url;

    public string $status;
}
