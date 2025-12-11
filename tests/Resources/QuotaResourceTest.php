<?php

namespace Label84\NederlandPostcode\Laravel\Tests\Resources;

use Label84\NederlandPostcode\DTO\Quota;
use Label84\NederlandPostcode\Laravel\Tests\TestCase;
use Label84\NederlandPostcode\NederlandPostcodeClient;

class QuotaResourceTest extends TestCase
{
    public function test_get(): void
    {
        $result = app(NederlandPostcodeClient::class)
            ->quota()
            ->get();

        $this->assertInstanceOf(Quota::class, $result);

        $this->assertEquals(1500, $result->used);
        $this->assertEquals(10000, $result->limit);
    }
}
