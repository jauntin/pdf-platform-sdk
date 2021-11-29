<?php

namespace Jauntin\PdfPlatformSdk\Template;

use Jauntin\PdfPlatformSdk\ResponseData;
use Jauntin\PdfPlatformSdk\Template\Module\ModuleResponseData;

class CreateTemplateResponseData extends ResponseData
{
    public string $id;
    /** @var ModuleResponseData[] $modules */
    public array $modules;
}
