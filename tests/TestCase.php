<?php

namespace Jauntin\PdfPlatformSdk\Tests;

use Jauntin\PdfPlatformSdk\PdfPlatformSdkServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            PdfPlatformSdkServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        // Setup any environment variables or configurations needed for testing
    }
}
