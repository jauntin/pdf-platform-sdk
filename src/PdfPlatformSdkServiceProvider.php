<?php

namespace Jauntin\PdfPlatformSdk;

use Illuminate\Support\ServiceProvider;

class PdfPlatformSdkServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('pdf-platform-sdk.php'),
            ], 'config');
        }
    }

    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'pdf-platform-sdk');

        $this->app->bind(ClientParameters::class, fn () => new ClientParameters([
            'location' => config('pdf-platform-sdk.location'),
            'clientId' => config('pdf-platform-sdk.clientId'),
            'clientSecret' => config('pdf-platform-sdk.clientSecret'),
        ]));
    }
}
