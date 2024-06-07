<?php

namespace Jauntin\PdfPlatformSdk\Template\Module;

use Jauntin\PdfPlatformSdk\ResponseData;

class ModuleResponseData extends ResponseData
{
    public string $id;

    public string $templateId;

    public string $type;

    public string $data;
}
