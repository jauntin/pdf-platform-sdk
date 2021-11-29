<?php

namespace Jauntin\PdfPlatformSdk\Document\Module;

use Jauntin\PdfPlatformSdk\Data;
use Jauntin\PdfPlatformSdk\Document\Module\DataPlacement\TextDataPlacement;
use Jauntin\PdfPlatformSdk\Document\Module\DataPlacement\CellDataPlacement;
use Jauntin\PdfPlatformSdk\Document\Module\DataPlacement\ImageDataPlacement;

class PdfModuleData extends Data
{
    public string $id;
    /** @var TextDataPlacement[]|CellDataPlacement[]|ImageDataPlacement[] */
    public array $dataPlacements;
}
