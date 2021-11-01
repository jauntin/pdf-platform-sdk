<?php

namespace Jauntin\PdfPlatformSdk\Template;

use Jauntin\PdfPlatformSdk\Request;

class CreateTemplateRequest extends Request
{
    protected string $method = 'POST';
    protected string $path = '/api/v1/templates';
}
