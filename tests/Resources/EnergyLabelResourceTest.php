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
                postcode: '1118BN',
                number: 800,
                addition: null,
            );

        $this->assertInstanceOf(EnergyLabelCollection::class, $result);
        $this->assertCount(1, $result);
    }

    public function test_multiple_energy_labels(): void
    {
        $result = app(NederlandPostcodeClient::class)
            ->energyLabels()
            ->get(
                postcode: '1015CN',
                number: 10,
                addition: null,
            );

        $this->assertInstanceOf(EnergyLabelCollection::class, $result);
        $this->assertCount(2, $result);
    }
}
