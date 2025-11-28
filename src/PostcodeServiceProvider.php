<?php

namespace Label84\NederlandPostcode;

use Illuminate\Support\ServiceProvider;

class PostcodeServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(NederlandPostcodeClient::class, function () {
            return new NederlandPostcodeClient(
                baseUrl: (string) config('nederland-postcode.base_url'), // @phpstan-ignore cast.string
                key: (string) config('nederland-postcode.api_key'), // @phpstan-ignore cast.string
                timeout: (int) config('nederland-postcode.timeout'), // @phpstan-ignore cast.int
                retryTimes: (int) config('nederland-postcode.retry_times'), // @phpstan-ignore cast.int
                retrySleep: (int) config('nederland-postcode.retry_sleep'), // @phpstan-ignore cast.int
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
