<?php

namespace Jauntin\PdfPlatformSdk\Document\Module;

use Jauntin\PdfPlatformSdk\ResponseData;

class PdfModuleResponseData extends ResponseData
{
    public string $id;
    /** @var mixed[] */
    public array $dataPlacements;
}
