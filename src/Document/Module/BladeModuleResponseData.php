<?php

namespace Jauntin\PdfPlatformSdk\Document\Module;

use Jauntin\PdfPlatformSdk\ResponseData;

class BladeModuleResponseData extends ResponseData
{
    public string $id;
    /** @var mixed[] */
    public array $variables;
}
