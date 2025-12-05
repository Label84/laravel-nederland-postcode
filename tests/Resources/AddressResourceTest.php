<?php

namespace Label84\NederlandPostcodeLaravel\Tests\Resources;

use Label84\NederlandPostcode\DTO\AddressCollection;
use Label84\NederlandPostcode\NederlandPostcodeClient;
use Label84\NederlandPostcodeLaravel\Tests\TestCase;

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
    }

    public function test_get_multiple_results(): void
    {
        $result = app(NederlandPostcodeClient::class)
            ->addresses()
            ->get(
                postcode: '1118BN',
                number: null,
                addition: null,
            );

        $this->assertInstanceOf(AddressCollection::class, $result);
        $this->assertCount(3, $result);
    }
}
