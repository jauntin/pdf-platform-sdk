<?php

namespace Jauntin\PdfPlatformSdk\Document\Module;

use Jauntin\PdfPlatformSdk\Data;

class BladeModuleData extends Data
{
    public string $id;
    /** @var array<string, string> */
    public array $variables;
}
