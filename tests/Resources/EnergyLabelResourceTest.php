<?php

namespace Label84\NederlandPostcode\Laravel\Tests\Resources;

use Label84\NederlandPostcode\DTO\EnergyLabelCollection;
use Label84\NederlandPostcode\Laravel\Tests\TestCase;
use Label84\NederlandPostcode\NederlandPostcodeClient;

class EnergyLabelResourceTest extends TestCase
{
    public function test_single_energy_label(): void
    {
        $result = app(NederlandPostcodeClient::class)
            ->energyLabels()
            ->get(
                postcode: '5465SM',
                number: 7,
                addition: null,
            );

        $this->assertInstanceOf(EnergyLabelCollection::class, $result);
        $this->assertCount(1, $result);

        $label = $result->all()[0];
        $this->assertSame('5465SM', $label->postcode);
        $this->assertSame(7, $label->number);
        $this->assertNull($label->addition);
        $this->assertSame('Klaverhoeve', $label->street);
        $this->assertSame('Veghel', $label->city);
        $this->assertSame('31-08-2026', $label->registrationDate->format('d-m-Y'));
        $this->assertSame('31-08-2026', $label->inspectionDate->format('d-m-Y'));
        $this->assertSame('31-08-2036', $label->validUntilDate->format('d-m-Y'));
        $this->assertSame('woningbouw', $label->constructionType);
        $this->assertSame('twee-onder-één-kap', $label->buildingType);
        $this->assertSame('A++++', $label->energyLabel);
        $this->assertSame('NTA 8800:2025 (detailopname woningbouw)', $label->calculationType);
        $this->assertSame('detail', $label->inspectionType);
        $this->assertSame('oplevering', $label->status);
        $this->assertSame(2025, $label->constructionYear);
        $this->assertSame(130.89, $label->usageAreaThermalZone);
        $this->assertSame(2.31, $label->compactness);
        $this->assertSame(76.54, $label->energyDemand);
        $this->assertSame(79.38, $label->energyDemandRequirement);
        $this->assertSame(-7.02, $label->primaryFossilEnergy);
        $this->assertSame(30.0, $label->primaryFossilEnergyRequirement);
        $this->assertNull($label->primaryFossilEnergyEmg);
        $this->assertSame(107.7, $label->renewableShare);
        $this->assertSame(50.0, $label->renewableShareRequirement);
        $this->assertNull($label->renewableShareEmg);
        $this->assertSame(-7.03, $label->calculatedEnergyConsumption);
        $this->assertSame(47.59, $label->heatDemand);
        $this->assertSame(-1.3, $label->calculatedCo2Emission);
        $this->assertSame(0.0, $label->temperatureExcess);
        $this->assertSame(1.2, $label->temperatureExcessRequirement);
    }

    public function test_multiple_energy_labels(): void
    {
        $result = app(NederlandPostcodeClient::class)
            ->energyLabels()
            ->get(
                postcode: '7316ER',
                number: 73,
                addition: null,
            );

        $this->assertInstanceOf(EnergyLabelCollection::class, $result);
        $this->assertCount(3, $result);

        $energyLabels = array_map(fn ($label) => $label->energyLabel, $result->all());
        $this->assertSame(['C', 'E', 'G'], $energyLabels);

        $first = $result->all()[0];
        $this->assertSame('7316ER', $first->postcode);
        $this->assertSame(73, $first->number);
        $this->assertNull($first->addition);
        $this->assertSame('Laan van Kerschoten', $first->street);
        $this->assertSame('Apeldoorn', $first->city);
        $this->assertSame('09-10-2025', $first->registrationDate->format('d-m-Y'));
        $this->assertSame('07-10-2025', $first->inspectionDate->format('d-m-Y'));
        $this->assertSame('07-10-2035', $first->validUntilDate->format('d-m-Y'));
        $this->assertSame('woningbouw', $first->constructionType);
        $this->assertSame('twee-onder-één-kap', $first->buildingType);
        $this->assertSame('basis', $first->inspectionType);
        $this->assertSame('bestaand', $first->status);
        $this->assertSame(1958, $first->constructionYear);
        $this->assertSame(177.57, $first->energyDemand);
        $this->assertSame(218.86, $first->primaryFossilEnergy);
        $this->assertSame(1.24, $first->temperatureExcess);
        $this->assertNull($first->temperatureExcessRequirement);

        $third = $result->all()[2];
        $this->assertSame('utiliteitsbouw', $third->constructionType);
        $this->assertNull($third->buildingType);
        $this->assertSame('G', $third->energyLabel);
        $this->assertSame(580.39, $third->primaryFossilEnergyEmg);
        $this->assertSame(3.2, $third->renewableShare);
        $this->assertSame(3.2, $third->renewableShareEmg);
    }
}
