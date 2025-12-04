<?php

namespace Label84\NederlandPostcode;

use Illuminate\Support\ServiceProvider;

class NederlandPostcodeServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(NederlandPostcodeClient::class, function () {
            return new NederlandPostcodeClient(
                baseUrl: (string) config('nederland-postcode.base_url'),
                key: (string) config('nederland-postcode.api_key'),
                timeout: (int) config('nederland-postcode.timeout'),
                retryTimes: (int) config('nederland-postcode.retry_times'),
                retrySleep: (int) config('nederland-postcode.retry_sleep'),
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
