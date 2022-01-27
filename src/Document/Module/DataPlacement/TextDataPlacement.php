<?php

namespace Jauntin\PdfPlatformSdk\Document\Module\DataPlacement;

use Jauntin\PdfPlatformSdk\Data;

class TextDataPlacement extends Data
{
    public string $type = "text";
    public int $page;
    public string $data;
    public float $x;
    public float $y;
    public ?string $font;
    public ?string $fontWeight;
    public ?int $fontSize;
    public ?array $color;
    public ?float $alpha;
    public ?float $angle;
}
