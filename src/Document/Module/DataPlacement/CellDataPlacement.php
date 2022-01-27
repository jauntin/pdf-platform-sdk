<?php

namespace Jauntin\PdfPlatformSdk\Document\Module\DataPlacement;

use Jauntin\PdfPlatformSdk\Data;

class CellDataPlacement extends Data
{
    public string $type = "cell";
    public int $page;
    public string $data;
    public float $x;
    public float $y;
    public float $width;
    public float $height;
    public ?float $border;
    public ?string $alignment;
    public ?string $font;
    public ?string $fontWeight;
    public ?int $fontSize;
    public ?array $color;
    public ?float $alpha;
    public ?float $angle;
}
