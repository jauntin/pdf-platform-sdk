<?php

namespace Jauntin\PdfPlatformSdk\Document\Module;

use Jauntin\PdfPlatformSdk\RequestData;

class BladeModuleRequestData extends RequestData
{
    public string $id;
    /** @var mixed[] */
    public array $variables;
}
