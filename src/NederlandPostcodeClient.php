<?php

namespace Label84\NederlandPostcode;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Label84\NederlandPostcode\DTO\Address;
use Label84\NederlandPostcode\DTO\AddressCollection;
use Label84\NederlandPostcode\Enums\AddressAttributesEnum;
use Label84\NederlandPostcode\Exceptions\AddressNotFoundException;
use Label84\NederlandPostcode\Exceptions\MultipleAddressesFoundException;
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

    /**
     * Fetch a list of addresses by postcode, number, and addition.
     *
     * @param  array<int|string, string|AddressAttributesEnum>  $attributes
     * @return AddressCollection<Address>
     */
    public function list(
        string $postcode,
        ?int $number = null,
        ?string $addition = null,
        array $attributes = [],
    ): AddressCollection {
        return $this->addresses()->get(
            postcode: $postcode,
            number: $number,
            addition: $addition,
            attributes: $attributes,
        );
    }

    /**
     * Fetch a single address by postcode, number, and addition.
     *
     * @param  array<int|string, string|AddressAttributesEnum>  $attributes
     *
     * @throws AddressNotFoundException
     * @throws MultipleAddressesFoundException
     */
    public function find(
        string $postcode,
        int $number,
        ?string $addition = null,
        array $attributes = [],
    ): Address {
        $addresses = $this->addresses()->get(
            postcode: $postcode,
            number: $number,
            addition: $addition,
            attributes: $attributes,
        );

        if ($addresses->isEmpty()) {
            throw new AddressNotFoundException;
        } elseif ($addresses->count() > 1) {
            throw new MultipleAddressesFoundException;
        }

        return $addresses->sole();
    }
}
