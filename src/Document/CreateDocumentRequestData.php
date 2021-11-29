<?php

namespace Jauntin\PdfPlatformSdk\Document;

use Jauntin\PdfPlatformSdk\Document\Module\BladeModuleRequestData;
use Jauntin\PdfPlatformSdk\Document\Module\PdfModuleRequestData;
use Jauntin\PdfPlatformSdk\RequestData;

class CreateDocumentRequestData extends RequestData
{
    public string $templateId;
    public string $path;
    /** @var BladeModuleRequestData[]|PdfModuleRequestData[] */
    public array $modules;
}
