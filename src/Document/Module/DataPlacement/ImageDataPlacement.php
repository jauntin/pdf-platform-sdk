<?php

namespace Jauntin\PdfPlatformSdk\Document\Module\DataPlacement;

use Jauntin\PdfPlatformSdk\Data;

class ImageDataPlacement extends Data
{
    public string $type = "image";
    public int $page;
    public string $data;
    public float $x;
    public float $y;
    public float $width;
    public float $height;
}
