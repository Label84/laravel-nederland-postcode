<?php

namespace Label84\NederlandPostcode\Factories;

use Label84\NederlandPostcode\DTO\Address;
use Label84\NederlandPostcode\DTO\AddressCollection;
use Label84\NederlandPostcode\DTO\Coordinates;

class AddressCollectionFactory
{
    /**
     * @param array{data: array<array{
     *     postcode: string,
     *     number: int,
     *     addition?: string|null,
     *     street: string,
     *     city: string,
     *     municipality: string,
     *     province: string,
     *     country: string,
     *     coordinates: array{latitude: float, longitude: float}
     * }>} $response
     */
    public static function make(array $response): AddressCollection
    {
        return new AddressCollection(
            collect($response['data'])->map(function (array $attributes) {
                return new Address(
                    postcode: $attributes['postcode'],
                    number: $attributes['number'],
                    addition: $attributes['addition'] ?? null,
                    street: $attributes['street'],
                    city: $attributes['city'],
                    municipality: $attributes['municipality'],
                    province: $attributes['province'],
                    country: $attributes['country'],
                    coordinates: new Coordinates(
                        latitude: $attributes['coordinates']['latitude'],
                        longitude: $attributes['coordinates']['longitude'],
                    ),
                );
            })
                ->values()
                ->all()
        );
    }
}
