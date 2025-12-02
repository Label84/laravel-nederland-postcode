<?php

namespace Label84\NederlandPostcode\Resources;

use Illuminate\Http\Request;
use Label84\NederlandPostcode\DTO\Quota;
use Label84\NederlandPostcode\Factories\QuotaFactory;

class QuotaResource extends BaseResource
{
    public function get(): Quota
    {
        // @phpstan-ignore-next-line
        return QuotaFactory::make($this->request(
            method: Request::METHOD_GET,
            path: 'quota',
        ));
    }
}
