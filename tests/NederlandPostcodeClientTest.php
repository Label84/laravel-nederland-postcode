<?php

namespace Label84\NederlandPostcode\Tests;

use Label84\NederlandPostcode\DTO\Address;
use Label84\NederlandPostcode\DTO\AddressCollection;
use Label84\NederlandPostcode\DTO\Quota;
use Label84\NederlandPostcode\Exceptions\AddressNotFoundException;
use Label84\NederlandPostcode\Exceptions\MultipleAddressesFoundException;
use Label84\NederlandPostcode\NederlandPostcodeClient;

class NederlandPostcodeClientTest extends TestCase
{
    public function test_find(): void
    {
        $result = app(NederlandPostcodeClient::class)
            ->find(
                postcode: '1118BN',
                number: 800,
                addition: null,
            );

        $this->assertInstanceOf(Address::class, $result);
    }

    public function test_find_throws_address_not_found_exception(): void
    {
        $this->expectException(AddressNotFoundException::class);

        app(NederlandPostcodeClient::class)
            ->find(
                postcode: '1118BN',
                number: 999,
                addition: null,
            );
    }

    public function test_find_throws_multiple_addresses_found_exception(): void
    {
        $this->expectException(MultipleAddressesFoundException::class);

        app(NederlandPostcodeClient::class)
            ->find(
                postcode: '1118BN',
                number: 0,
                addition: null,
            );
    }

    public function test_list(): void
    {
        $result = app(NederlandPostcodeClient::class)
            ->list(
                postcode: '1118BN',
                number: null,
                addition: null,
            );

        $this->assertInstanceOf(AddressCollection::class, $result);
        $this->assertCount(3, $result);
    }

    public function test_usage(): void
    {
        $result = app(NederlandPostcodeClient::class)
            ->usage();

        $this->assertInstanceOf(Quota::class, $result);

        $quota = $result;

        $this->assertEquals(1500, $quota->used);
        $this->assertEquals(10000, $quota->limit);
    }
}
