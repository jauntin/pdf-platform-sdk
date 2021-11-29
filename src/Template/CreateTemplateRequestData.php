<?php

namespace Jauntin\PdfPlatformSdk\Template;

use Jauntin\PdfPlatformSdk\RequestData;
use Jauntin\PdfPlatformSdk\Template\Module\ModuleRequestData;

class CreateTemplateRequestData extends RequestData
{
    public string $id;
    /** @var ModuleRequestData[] $modules */
    public array $modules;
}
