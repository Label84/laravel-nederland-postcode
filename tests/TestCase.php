<?php

namespace Label84\NederlandPostcode\Tests;

use Label84\NederlandPostcode\DTO\Address;
use Label84\NederlandPostcode\DTO\AddressCollection;
use Label84\NederlandPostcode\DTO\Coordinates;
use Label84\NederlandPostcode\DTO\Quota;
use Label84\NederlandPostcode\Exceptions\AddressNotFoundException;
use Label84\NederlandPostcode\Exceptions\MultipleAddressesFoundException;
use Label84\NederlandPostcode\NederlandPostcodeClient;
use Label84\NederlandPostcode\NederlandPostcodeServiceProvider;
use Label84\NederlandPostcode\Resources\AddressesResource;
use Label84\NederlandPostcode\Resources\QuotaResource;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->mockNederlandPostcodeClient();
    }

    protected function getPackageProviders($app): array
    {
        return [
            NederlandPostcodeServiceProvider::class,
        ];
    }

    protected function mockNederlandPostcodeClient(): void
    {
        $mockClient = $this
            ->getMockBuilder(NederlandPostcodeClient::class)
            ->disableOriginalConstructor()
            ->onlyMethods([
                'addresses',
                'quota',
                'find',
                'list',
                'usage',
            ])
            ->getMock();

        $mockAddresses = $this->createMock(AddressesResource::class);
        $mockQuota = $this->createMock(QuotaResource::class);

        $mockAddresses
            ->method('get')
            ->willReturnCallback(function (string $postcode, ?int $number, ?array $addition, $attributes = []) {
                if ($postcode === '1118BN' && $number === 800) {
                    return $this->singleAddressResponse();
                } elseif ($postcode === '1118BN' && $number === null) {
                    return $this->multipleAddressesResponse();
                }

                return new AddressCollection([]);
            });

        $mockQuota
            ->method('get')
            ->willReturnCallback(function () {
                return new Quota(
                    used: 1500,
                    limit: 10000,
                );
            });

        $mockClient
            ->method('addresses')
            ->willReturn($mockAddresses);

        $mockClient
            ->method('quota')
            ->willReturn($mockQuota);

        $mockClient
            ->method('find')
            ->willReturnCallback(function (string $postcode, int $number, ?array $addition, $attributes = []) {
                if ($postcode === '1118BN' && $number === 800) {
                    return $this->singleAddressResponse()->first();
                } elseif ($postcode === '1118BN' && $number === 999) {
                    throw new AddressNotFoundException;
                }

                throw new MultipleAddressesFoundException;
            });

        $mockClient
            ->method('list')
            ->willReturnCallback(function (string $postcode, ?int $number, ?array $addition, $attributes = []) {
                if ($postcode === '1118BN') {
                    return $this->multipleAddressesResponse();
                }

                return new AddressCollection([]);
            });

        $mockClient
            ->method('usage')
            ->willReturnCallback(function () {
                return new Quota(
                    used: 1500,
                    limit: 10000,
                );
            });

        $this->app->instance(NederlandPostcodeClient::class, $mockClient);
    }

    private function singleAddressResponse(): AddressCollection
    {
        return new AddressCollection([
            new Address(
                postcode: '1118BN',
                number: 800,
                addition: '',
                street: 'Schiphol Boulevard',
                city: 'Schiphol',
                municipality: 'Haarlemmermeer',
                province: 'Noord-Holland',
                country: 'Nederland',
                coordinates: new Coordinates(
                    latitude: 52.30528553688755,
                    longitude: 4.750645160863609,
                ),
            ),
        ]);
    }

    private function multipleAddressesResponse(): AddressCollection
    {
        return new AddressCollection([
            new Address(
                postcode: '1118BN',
                number: 701,
                addition: '',
                street: 'Schiphol Boulevard',
                city: 'Schiphol',
                municipality: 'Haarlemmermeer',
                province: 'Noord-Holland',
                country: 'Nederland',
                coordinates: new Coordinates(
                    latitude: 52.30703569036619,
                    longitude: 4.755174782205992,
                ),
            ),
            new Address(
                postcode: '1118BN',
                number: 800,
                addition: '',
                street: 'Schiphol Boulevard',
                city: 'Schiphol',
                municipality: 'Haarlemmermeer',
                province: 'Noord-Holland',
                country: 'Nederland',
                coordinates: new Coordinates(
                    latitude: 52.30528553688755,
                    longitude: 4.750645160863609,
                ),
            ),
            new Address(
                postcode: '1118BN',
                number: 810,
                addition: '',
                street: 'Schiphol Boulevard',
                city: 'Schiphol',
                municipality: 'Haarlemmermeer',
                province: 'Noord-Holland',
                country: 'Nederland',
                coordinates: new Coordinates(
                    latitude: 52.30556719835437,
                    longitude: 4.750419372039126,
                ),
            ),
        ]);
    }
}
