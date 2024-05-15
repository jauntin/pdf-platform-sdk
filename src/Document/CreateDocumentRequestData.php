<?php

namespace Jauntin\PdfPlatformSdk\Document;

use Jauntin\PdfPlatformSdk\Document\Module\BladeModuleData;
use Jauntin\PdfPlatformSdk\Document\Module\DataPlacement\CellDataPlacement;
use Jauntin\PdfPlatformSdk\Document\Module\DataPlacement\ImageDataPlacement;
use Jauntin\PdfPlatformSdk\Document\Module\DataPlacement\TextDataPlacement;
use Jauntin\PdfPlatformSdk\Document\Module\DocumentModuleData;
use Jauntin\PdfPlatformSdk\Document\Module\PdfModuleData;
use Jauntin\PdfPlatformSdk\RequestData;

class CreateDocumentRequestData extends RequestData
{
    public string $templateId;
    public string $path;
    /** @var BladeModuleData[]|PdfModuleData[]|DocumentModuleData[]|array<int,array<string,mixed>> */
    public array $modules;
    /** @var CellDataPlacement[]|ImageDataPlacement[]|TextDataPlacement[]|array<int,array<string,mixed>> */
    public ?array $dataPlacements = null;
}
