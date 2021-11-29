<?php

namespace Jauntin\PdfPlatformSdk\Document\Module;

use Jauntin\PdfPlatformSdk\RequestData;

class PdfModuleRequestData extends RequestData
{
    public string $id;
    /** @var mixed[] */
    public array $dataPlacements;
}
