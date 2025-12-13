<?php

namespace Label84\NederlandPostcode\Laravel\Tests;

use Label84\NederlandPostcode\DTO\Address;
use Label84\NederlandPostcode\DTO\AddressCollection;
use Label84\NederlandPostcode\DTO\Coordinates;
use Label84\NederlandPostcode\DTO\Quota;
use Label84\NederlandPostcode\Laravel\NederlandPostcodeServiceProvider;
use Label84\NederlandPostcode\NederlandPostcodeClient;
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
        $mockAddresses = $this->createStub(AddressesResource::class);
        $mockAddresses
            ->method('get')
            ->willReturnCallback(function (string $postcode, int $number, ?array $addition, $attributes = []) {
                return match (true) {
                    $postcode === '1118BN' && $number === 800 => $this->singleAddressResponse(),
                    $postcode === '1015CN' && $number === 10 => $this->multipleAddressesResponse(),
                    default => new AddressCollection([]),
                };
            });

        $mockQuota = $this->createStub(QuotaResource::class);
        $mockQuota
            ->method('get')
            ->willReturnCallback(function () {
                return new Quota(
                    used: 1500,
                    limit: 10000,
                );
            });

        $mockClient = $this->createStub(NederlandPostcodeClient::class);
        $mockClient
            ->method('addresses')
            ->willReturn($mockAddresses);

        $mockClient
            ->method('quota')
            ->willReturn($mockQuota);

        $this->app->instance(
            NederlandPostcodeClient::class,
            new class($mockAddresses, $mockQuota) extends NederlandPostcodeClient
            {
                public AddressesResource $addressesResource;

                public QuotaResource $quotaResource;

                public function __construct($addresses, $quota)
                {
                    $this->addressesResource = $addresses;
                    $this->quotaResource = $quota;
                }

                public function addresses(): AddressesResource
                {
                    return $this->addressesResource;
                }

                public function quota(): QuotaResource
                {
                    return $this->quotaResource;
                }
            }
        );
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
                postcode: '1015CN',
                number: 10,
                addition: 'A',
                street: 'Keizersgracht',
                city: 'Amsterdam',
                municipality: 'Amsterdam',
                province: 'Noord-Holland',
                country: 'Nederland',
                coordinates: new Coordinates(
                    latitude: 52.379401496779124,
                    longitude: 4.889216673725493,
                ),
            ),
            new Address(
                postcode: '1015CN',
                number: 10,
                addition: 'B',
                street: 'Keizersgracht',
                city: 'Amsterdam',
                municipality: 'Amsterdam',
                province: 'Noord-Holland',
                country: 'Nederland',
                coordinates: new Coordinates(
                    latitude: 52.379401496779124,
                    longitude: 4.889216673725493,
                ),
            ),
            new Address(
                postcode: '1015CN',
                number: 10,
                addition: 'C',
                street: 'Keizersgracht',
                city: 'Amsterdam',
                municipality: 'Amsterdam',
                province: 'Noord-Holland',
                country: 'Nederland',
                coordinates: new Coordinates(
                    latitude: 52.379401496779124,
                    longitude: 4.889216673725493,
                ),
            ),
            new Address(
                postcode: '1015CN',
                number: 10,
                addition: 'D',
                street: 'Keizersgracht',
                city: 'Amsterdam',
                municipality: 'Amsterdam',
                province: 'Noord-Holland',
                country: 'Nederland',
                coordinates: new Coordinates(
                    latitude: 52.379401496779124,
                    longitude: 4.889216673725493,
                ),
            ),
        ]);
    }
}
