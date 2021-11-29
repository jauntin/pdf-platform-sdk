<?php

namespace Jauntin\PdfPlatformSdk\Template\Module;

use Jauntin\PdfPlatformSdk\RequestData;

class ModuleRequestData extends RequestData
{
    public string $id;
    public string $type;
    public string $data;
}
