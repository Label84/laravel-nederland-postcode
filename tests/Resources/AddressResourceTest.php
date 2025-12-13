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
    }
}
