<?php

namespace Label84\NederlandPostcode\Resources;

use Illuminate\Http\Request;
use Label84\NederlandPostcode\DTO\AddressCollection;
use Label84\NederlandPostcode\Enums\AddressAttributesEnum;
use Label84\NederlandPostcode\Factories\AddressCollectionFactory;

class AddressesResource extends BaseResource
{
    /**
     * @param  array<AddressAttributesEnum|string>  $attributes
     */
    public function get(
        string $postcode,
        ?string $number,
        ?string $addition,
        array $attributes = [],
    ): AddressCollection {
        // @phpstan-ignore-next-line
        return AddressCollectionFactory::make($this->request(
            method: Request::METHOD_GET,
            path: 'address',
            query: [
                'postcode' => $postcode,
                'number' => $number,
                'addition' => $addition,
                'attributes' => array_map(
                    static fn (AddressAttributesEnum|string $attr) => $attr instanceof AddressAttributesEnum ? $attr->value : $attr,
                    $attributes
                ),
            ],
        ));
    }
}
