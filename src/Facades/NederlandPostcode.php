<?php

namespace Label84\NederlandPostcode\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Label84\NederlandPostcode\Resources\AddressesResource addresses()
 *
 * @see \Label84\NederlandPostcode\NederlandPostcodeClient
 */
class NederlandPostcode extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Label84\NederlandPostcode\NederlandPostcodeClient::class;
    }
}
