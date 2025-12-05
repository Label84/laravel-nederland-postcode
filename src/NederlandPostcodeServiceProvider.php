<?php

namespace Label84\NederlandPostcodeLaravel;

use Illuminate\Support\ServiceProvider;

class NederlandPostcodeServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(NederlandPostcode::class, function () {
            return new NederlandPostcode(
                key: (string) config('nederland-postcode.api_key'),
                baseUrl: (string) config('nederland-postcode.base_url'),
                timeout: (int) config('nederland-postcode.timeout'),
            );
        });
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/nederland-postcode.php' => config_path('nederland-postcode.php'),
        ], 'config');
    }
}
