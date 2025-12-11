<?php

namespace Label84\NederlandPostcode\Laravel\Facades;

use Illuminate\Support\Facades\Facade;
use Label84\NederlandPostcode\DTO\Address;
use Label84\NederlandPostcode\DTO\AddressCollection;
use Label84\NederlandPostcode\DTO\Quota;
use Label84\NederlandPostcode\Enums\AddressAttributesEnum;
use Label84\NederlandPostcode\Resources\AddressesResource;
use Label84\NederlandPostcode\Resources\QuotaResource;

/**
 * @method static Address find(string $postcode, string $number, ?string $addition = null, array<int|string, string|AddressAttributesEnum> $attributes = [])
 * @method static AddressCollection<Address> list(string $postcode, ?string $number = null, ?string $addition = null, array<int|string, string|AddressAttributesEnum> $attributes = [])
 * @method static Quota usage()
 * @method static AddressesResource addresses()
 * @method static QuotaResource quota()
 *
 * @see \Label84\NederlandPostcode\Laravel\NederlandPostcodeClient
 */
class NederlandPostcode extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Label84\NederlandPostcode\Laravel\NederlandPostcode::class;
    }
}
