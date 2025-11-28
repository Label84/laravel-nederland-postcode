<?php

namespace Label84\NederlandPostcode\DTO;

class Coordinates
{
    public function __construct(
        public readonly float $latitude,
        public readonly float $longitude,
    ) {}
}
