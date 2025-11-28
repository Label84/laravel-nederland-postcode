<?php

namespace Label84\NederlandPostcode;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Label84\NederlandPostcode\Resources\AddressesResource;

class NederlandPostcodeClient
{
    public function __construct(
        public string $baseUrl,
        public string $key,
        public int $timeout,
        public ?int $retryTimes = null,
        public ?int $retrySleep = null,
    ) {}

    public function makeRequest(): PendingRequest
    {
        $request = Http::withHeaders([
            //
        ])
            ->withToken($this->key)
            ->acceptJson()
            ->baseUrl($this->baseUrl)
            ->timeout($this->timeout);

        if ($this->retryTimes != null && $this->retrySleep != null) {
            $request->retry($this->retryTimes, $this->retrySleep);
        }

        return $request;
    }

    public function addresses(): AddressesResource
    {
        return new AddressesResource($this);
    }
}
