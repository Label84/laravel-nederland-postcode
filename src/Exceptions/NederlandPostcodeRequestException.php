<?php

namespace Label84\NederlandPostcode\Exceptions;

use Illuminate\Http\Client\RequestException;

class NederlandPostcodeRequestException extends NederlandPostcodeException
{
    public function __construct(RequestException $exception)
    {
        parent::__construct(
            $exception->getMessage(),
            $exception->getCode(),
            $exception,
        );
    }
}
