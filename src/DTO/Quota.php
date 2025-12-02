<?php

namespace Label84\NederlandPostcode\DTO;

class Quota
{
    public function __construct(
        public readonly int $used,
        public readonly int $limit,
    ) {}
}
