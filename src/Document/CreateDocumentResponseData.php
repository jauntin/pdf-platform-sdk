<?php

namespace Jauntin\PdfPlatformSdk\Document;

use Jauntin\PdfPlatformSdk\Document\Module\BladeModuleResponseData;
use Jauntin\PdfPlatformSdk\Document\Module\PdfModuleResponseData;
use Jauntin\PdfPlatformSdk\ResponseData;

class CreateDocumentResponseData extends ResponseData
{
    public string $id;
    public string $templateId;
    public string $status;
    public string $path;
    /** @var BladeModuleResponseData[]|PdfModuleResponseData[] */
    public array $modules;
}
