<?php

namespace Jauntin\PdfPlatformSdk\Document;

use Jauntin\PdfPlatformSdk\Document\Module\BladeModuleData;
use Jauntin\PdfPlatformSdk\Document\Module\PdfModuleData;
use Jauntin\PdfPlatformSdk\ResponseData;

class GetDocumentResponseData extends ResponseData
{
    public string $id;
    public string $templateId;
    public string $status;
    public string $path;
    /** @var BladeModuleData[]|PdfModuleData[] */
    public array $modules;
}
