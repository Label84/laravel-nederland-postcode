<?php

namespace Label84\NederlandPostcode\Laravel\Tests;

use DateTime;
use Label84\NederlandPostcode\DTO\Address;
use Label84\NederlandPostcode\DTO\AddressCollection;
use Label84\NederlandPostcode\DTO\Coordinates;
use Label84\NederlandPostcode\DTO\EnergyLabel;
use Label84\NederlandPostcode\DTO\EnergyLabelCollection;
use Label84\NederlandPostcode\DTO\Quota;
use Label84\NederlandPostcode\Laravel\NederlandPostcodeServiceProvider;
use Label84\NederlandPostcode\NederlandPostcodeClient;
use Label84\NederlandPostcode\Resources\AddressesResource;
use Label84\NederlandPostcode\Resources\EnergyLabelResource;
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

        $mockEnergyLabels = $this->createStub(EnergyLabelResource::class);
        $mockEnergyLabels->method('get')
            ->willReturnCallback(function (string $postcode, int $number, ?string $addition) {
                return match (true) {
                    $postcode === '5465SM' && $number === 7 => $this->singleEnergyLabelsResponse(),
                    $postcode === '7316ER' && $number === 73 => $this->multipleEnergyLabelsResponse(),
                    default => new EnergyLabelCollection([]),
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
            new class($mockAddresses, $mockEnergyLabels, $mockQuota) extends NederlandPostcodeClient
            {
                public AddressesResource $addressesResource;

                public EnergyLabelResource $energyLabelsResource;

                public QuotaResource $quotaResource;

                public function __construct(AddressesResource $addresses, EnergyLabelResource $energyLabels, QuotaResource $quota)
                {
                    $this->addressesResource = $addresses;
                    $this->energyLabelsResource = $energyLabels;
                    $this->quotaResource = $quota;
                }

                public function addresses(): AddressesResource
                {
                    return $this->addressesResource;
                }

                public function energyLabels(): EnergyLabelResource
                {
                    return $this->energyLabelsResource;
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
                district: null,
                neighborhood: null,
                function: null,
                location_status: null,
                property_status: null,
                surface_area: null,
                construction_year: null,
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
                district: null,
                neighborhood: null,
                function: null,
                location_status: null,
                property_status: null,
                surface_area: null,
                construction_year: null,
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
                district: null,
                neighborhood: null,
                function: null,
                location_status: null,
                property_status: null,
                surface_area: null,
                construction_year: null,
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
                district: null,
                neighborhood: null,
                function: null,
                location_status: null,
                property_status: null,
                surface_area: null,
                construction_year: null,
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
                district: null,
                neighborhood: null,
                function: null,
                location_status: null,
                property_status: null,
                surface_area: null,
                construction_year: null,
            ),
        ]);
    }

    private function singleEnergyLabelsResponse(): EnergyLabelCollection
    {
        return new EnergyLabelCollection([
            new EnergyLabel(
                postcode: '5465SM',
                number: 7,
                addition: null,
                street: 'Klaverhoeve',
                city: 'Veghel',
                registrationDate: DateTime::createFromFormat('d-m-Y', '31-08-2026'),
                inspectionDate: DateTime::createFromFormat('d-m-Y', '31-08-2026'),
                validUntilDate: DateTime::createFromFormat('d-m-Y', '31-08-2036'),
                constructionType: 'woningbouw',
                buildingType: 'twee-onder-één-kap',
                energyLabel: 'A++++',
                calculationType: 'NTA 8800:2025 (detailopname woningbouw)',
                inspectionType: 'detail',
                status: 'oplevering',
                constructionYear: 2025,
                usageAreaThermalZone: 130.89,
                compactness: 2.31,
                energyDemand: 76.54,
                energyDemandRequirement: 79.38,
                primaryFossilEnergy: -7.02,
                primaryFossilEnergyRequirement: 30,
                primaryFossilEnergyEmg: null,
                renewableShare: 107.7,
                renewableShareRequirement: 50,
                renewableShareEmg: null,
                calculatedEnergyConsumption: -7.03,
                heatDemand: 47.59,
                calculatedCo2Emission: -1.3,
                temperatureExcess: 0,
                temperatureExcessRequirement: 1.2,
            ),
        ]);
    }

    private function multipleEnergyLabelsResponse(): EnergyLabelCollection
    {
        return new EnergyLabelCollection([
            new EnergyLabel(
                postcode: '7316ER',
                number: 73,
                addition: null,
                street: 'Laan van Kerschoten',
                city: 'Apeldoorn',
                registrationDate: DateTime::createFromFormat('d-m-Y', '09-10-2025'),
                inspectionDate: DateTime::createFromFormat('d-m-Y', '07-10-2025'),
                validUntilDate: DateTime::createFromFormat('d-m-Y', '07-10-2035'),
                constructionType: 'woningbouw',
                buildingType: 'twee-onder-één-kap',
                energyLabel: 'C',
                calculationType: 'NTA 8800:2024 (basisopname woningbouw)',
                inspectionType: 'basis',
                status: 'bestaand',
                constructionYear: 1958,
                usageAreaThermalZone: 138.51,
                compactness: 2.13,
                energyDemand: 177.57,
                energyDemandRequirement: null,
                primaryFossilEnergy: 218.86,
                primaryFossilEnergyRequirement: null,
                primaryFossilEnergyEmg: null,
                renewableShare: 11,
                renewableShareRequirement: null,
                renewableShareEmg: null,
                calculatedEnergyConsumption: 218.86,
                heatDemand: 177.83,
                calculatedCo2Emission: 38.68,
                temperatureExcess: 1.24,
                temperatureExcessRequirement: null,
            ),
            new EnergyLabel(
                postcode: '7316ER',
                number: 73,
                addition: null,
                street: 'Laan van Kerschoten',
                city: 'Apeldoorn',
                registrationDate: DateTime::createFromFormat('d-m-Y', '19-10-2021'),
                inspectionDate: DateTime::createFromFormat('d-m-Y', '19-08-2021'),
                validUntilDate: DateTime::createFromFormat('d-m-Y', '19-08-2031'),
                constructionType: 'woningbouw',
                buildingType: 'vrijstaande woning',
                energyLabel: 'E',
                calculationType: 'NTA 8800:2020 (basisopname woningbouw)',
                inspectionType: 'basis',
                status: 'bestaand',
                constructionYear: 1958,
                usageAreaThermalZone: 139.42,
                compactness: 2.03,
                energyDemand: 238.61,
                energyDemandRequirement: null,
                primaryFossilEnergy: 334.74,
                primaryFossilEnergyRequirement: null,
                primaryFossilEnergyEmg: 334.74,
                renewableShare: 0,
                renewableShareRequirement: null,
                renewableShareEmg: 0,
                calculatedEnergyConsumption: 334.55,
                heatDemand: 237.55,
                calculatedCo2Emission: 61.29,
                temperatureExcess: 2,
                temperatureExcessRequirement: null,
            ),
            new EnergyLabel(
                postcode: '7316ER',
                number: 73,
                addition: null,
                street: 'Laan van Kerschoten',
                city: 'Apeldoorn',
                registrationDate: DateTime::createFromFormat('d-m-Y', '19-10-2021'),
                inspectionDate: DateTime::createFromFormat('d-m-Y', '19-08-2021'),
                validUntilDate: DateTime::createFromFormat('d-m-Y', '19-08-2031'),
                constructionType: 'utiliteitsbouw',
                buildingType: null,
                energyLabel: 'G',
                calculationType: 'NTA 8800:2020 (basisopname utiliteitsbouw)',
                inspectionType: 'basis',
                status: 'bestaand',
                constructionYear: 1958,
                usageAreaThermalZone: 79.79,
                compactness: 3.51,
                energyDemand: 472,
                energyDemandRequirement: null,
                primaryFossilEnergy: 580.39,
                primaryFossilEnergyRequirement: null,
                primaryFossilEnergyEmg: 580.39,
                renewableShare: 3.2,
                renewableShareRequirement: null,
                renewableShareEmg: 3.2,
                calculatedEnergyConsumption: 596.67,
                heatDemand: 452.11,
                calculatedCo2Emission: 105.77,
                temperatureExcess: 1.46,
                temperatureExcessRequirement: null,
            ),
        ]);
    }
}
