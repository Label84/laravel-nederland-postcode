<?php

namespace Label84\Nederland\PostcodeLaravel\Tests\Resources;

use Label84\NederlandPostcode\DTO\AddressCollection;
use Label84\NederlandPostcode\Laravel\Tests\TestCase;
use Label84\NederlandPostcode\NederlandPostcodeClient;

class AddressResourceTest extends TestCase
{
    public function test_get_single_result(): void
    {
        $result = app(NederlandPostcodeClient::class)
            ->addresses()
            ->get(
                postcode: '1118BN',
                number: 800,
                addition: null,
            );

        $this->assertInstanceOf(AddressCollection::class, $result);
        $this->assertCount(1, $result);

        $address = $result->all()[0];
        $this->assertSame('1118BN', $address->postcode);
        $this->assertSame(800, $address->number);
        $this->assertSame('', $address->addition);
        $this->assertSame('Schiphol Boulevard', $address->street);
        $this->assertSame('Schiphol', $address->city);
        $this->assertSame('Haarlemmermeer', $address->municipality);
        $this->assertSame('Noord-Holland', $address->province);
        $this->assertSame('Nederland', $address->country);
        $this->assertSame(52.30528553688755, $address->coordinates->latitude);
        $this->assertSame(4.750645160863609, $address->coordinates->longitude);
        $this->assertNull($address->neighborhood);
        $this->assertNull($address->district);
        $this->assertNull($address->function);
        $this->assertNull($address->location_status);
        $this->assertNull($address->property_status);
        $this->assertNull($address->surface_area);
        $this->assertNull($address->construction_year);
    }

    public function test_get_multiple_results(): void
    {
        $result = app(NederlandPostcodeClient::class)
            ->addresses()
            ->get(
                postcode: '1015CN',
                number: 10,
                addition: null,
            );

        $this->assertInstanceOf(AddressCollection::class, $result);
        $this->assertCount(4, $result);

        $additions = array_map(fn ($address) => $address->addition, $result->all());
        $this->assertSame(['A', 'B', 'C', 'D'], $additions);

        $first = $result->all()[0];
        $this->assertSame('1015CN', $first->postcode);
        $this->assertSame(10, $first->number);
        $this->assertSame('Keizersgracht', $first->street);
        $this->assertSame('Amsterdam', $first->city);
        $this->assertSame('Amsterdam', $first->municipality);
        $this->assertSame('Noord-Holland', $first->province);
        $this->assertSame('Nederland', $first->country);
        $this->assertSame(52.379401496779124, $first->coordinates->latitude);
        $this->assertSame(4.889216673725493, $first->coordinates->longitude);
    }
}
