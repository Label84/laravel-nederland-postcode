<?php

namespace Label84\NederlandPostcodeLaravel;

use Label84\NederlandPostcode\DTO\Address;
use Label84\NederlandPostcode\DTO\AddressCollection;
use Label84\NederlandPostcode\DTO\Quota;
use Label84\NederlandPostcode\Enums\AddressAttributesEnum;
use Label84\NederlandPostcode\Exceptions\AddressNotFoundException;
use Label84\NederlandPostcode\Exceptions\MultipleAddressesFoundException;
use Label84\NederlandPostcode\NederlandPostcodeClient as CoreClient;
use Label84\NederlandPostcode\Resources\AddressesResource;
use Label84\NederlandPostcode\Resources\QuotaResource;

class NederlandPostcode
{
    protected CoreClient $core;

    /**
     * @param  array<string, string>  $headers
     */
    public function __construct(
        string $key,
        string $baseUrl = \Label84\NederlandPostcode\NederlandPostcodeClient::DEFAULT_BASE_URL,
        int $timeout = 5,
        array $headers = []
    ) {
        $this->core = new \Label84\NederlandPostcode\NederlandPostcodeClient(
            key: $key,
            baseUrl: $baseUrl,
            timeout: $timeout,
            headers: $headers
        );
    }

    public function addresses(): AddressesResource
    {
        return new AddressesResource($this->core);
    }

    public function quota(): QuotaResource
    {
        return new QuotaResource($this->core);
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
        array $attributes = []
    ): AddressCollection {
        return $this->core->list(
            postcode: $postcode,
            number: $number,
            addition: $addition,
            attributes: $attributes
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
        array $attributes = []
    ): Address {
        return $this->core->find(
            postcode: $postcode,
            number: $number,
            addition: $addition,
            attributes: $attributes
        );
    }

    /**
     * Fetch the current quota usage.
     */
    public function usage(): Quota
    {
        return $this->quota()->get();
    }
}
