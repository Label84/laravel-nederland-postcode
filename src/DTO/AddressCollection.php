<?php

namespace Label84\NederlandPostcode\DTO;

use Illuminate\Support\Collection;

/**
 * @extends Collection<int, Address>
 */
class AddressCollection extends Collection
{
    /**
     * @param  array<int, Address>  $items
     */
    public function __construct(array $items = [])
    {
        parent::__construct($items);
    }
}
