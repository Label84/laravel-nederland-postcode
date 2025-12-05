<?php

namespace Label84\NederlandPostcodeLaravel\Tests\Resources;

use Label84\NederlandPostcode\DTO\Quota;
use Label84\NederlandPostcode\NederlandPostcodeClient;
use Label84\NederlandPostcodeLaravel\Tests\TestCase;

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
