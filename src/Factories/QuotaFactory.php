<?php

namespace Label84\NederlandPostcode\Factories;

use Label84\NederlandPostcode\DTO\Quota;

class QuotaFactory
{
    /**
     * @param  array{data: array{quota: array{used: int, limit: int}}}  $response
     */
    public static function make(array $response): Quota
    {
        return new Quota(
            used: $response['data']['quota']['used'],
            limit: $response['data']['quota']['limit'],
        );
    }
}
