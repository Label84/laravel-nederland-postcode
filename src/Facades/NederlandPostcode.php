<?php

namespace Label84\NederlandPostcode\Facades;

use Illuminate\Support\Facades\Facade;
use Label84\NederlandPostcode\DTO\Address;
use Label84\NederlandPostcode\DTO\AddressCollection;
use Label84\NederlandPostcode\Enums\AddressAttributesEnum;
use Label84\NederlandPostcode\Resources\AddressesResource;

/**
 * @method static Address find(string $postcode, string $number, ?string $addition = null, array<string, string|AddressAttributesEnum> $attributes = [])
 * @method static AddressCollection<Address> list(string $postcode, ?string $number = null, ?string $addition = null, array<string, string|AddressAttributesEnum> $attributes = [])
 * @method static AddressesResource addresses()
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
