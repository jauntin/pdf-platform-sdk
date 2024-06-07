<?php

namespace Jauntin\PdfPlatformSdk\Document;

use Jauntin\PdfPlatformSdk\Document\Module\BladeModuleData;
use Jauntin\PdfPlatformSdk\Document\Module\DataPlacement\CellDataPlacement;
use Jauntin\PdfPlatformSdk\Document\Module\DataPlacement\ImageDataPlacement;
use Jauntin\PdfPlatformSdk\Document\Module\DataPlacement\TextDataPlacement;
use Jauntin\PdfPlatformSdk\Document\Module\DocumentModuleData;
use Jauntin\PdfPlatformSdk\Document\Module\PdfModuleData;
use Jauntin\PdfPlatformSdk\ResponseData;

class GetDocumentResponseData extends ResponseData
{
    public string $id;

    public string $templateId;

    public string $status;

    public string $path;

    /** @var BladeModuleData[]|PdfModuleData[]|DocumentModuleData[] */
    public array $modules;

    /** @var CellDataPlacement[]|ImageDataPlacement[]|TextDataPlacement[] */
    public ?array $dataPlacements = null;
}
