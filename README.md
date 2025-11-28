# Nederland Postcode Laravel

![Nederland Postcode API](./docs/nederlandpostcodeapi.png)

Nederland Postcode Laravel makes it easy to integrate Dutch address lookups into your Laravel application using the [Nederland Postcode API](https://nederlandpostcode.nl).

Register for free to obtain a **test API key** at [nederlandpostcode.nl](https://nederlandpostcode.nl) to get started.

- [Requirements](#requirements)
- [Installation](#installation)
- [Usage](#usage)
  - [Address Endpoint](#address-endpoint)
    - [Fetching multiple addresses](#fetching-multiple-addresses)
    - [Fetching a single address](#fetching-a-single-address)
  - [Error Handling](#error-handling)

## Requirements

- Laravel 12.x
- PHP 8.2+

## Installation

Install the package via Composer:

```bash
composer require label84/laravel-nederland-postcode
```

Publish the configuration file:

```bash
php artisan vendor:publish --provider="Label84\NederlandPostcode\PostcodeServiceProvider" --tag="config"
```

Add your API key to your `.env` file:

```env
NEDERLAND_POSTCODE_API_KEY="your_api_key_here"
```

## Usage

## Address Endpoint

You can retrieve addresses by postcode and house number using the addresses endpoint.

The `postcode` parameter is required, while `number` and `addition` are optional.

The `attributes` parameter lets you include additional data in the response such as coordinates.

```php
use Label84\NederlandPostcode\Facades\NederlandPostcode;
use Label84\NederlandPostcode\Enums\AddressAttributesEnum;

$addresses = NederlandPostcode::addresses()->get(
        postcode: '1118BN',
        number: 800,
        addition: null,
        attributes: [
            AddressAttributesEnum::COORDINATES,
        ]
    );
```

The above code will return an `AddressCollection` like this:

```php
AddressCollection {
    items: [
        Address {
            postcode: "1118BN",
            number: 800,
            street: "Schiphol Boulevard",
            city: "Schiphol",
            municipality: "Haarlemmermeer",
            province: "Noord-Holland",
            coordinates: Coordinates {
                latitude: 52.30528553688755,
                longitude: 4.750645160863609
            }
        }
    ]
}
```

### Fetching multiple addresses

The `get` method retrieves all addresses matching the provided criteria:

```php
use Label84\NederlandPostcode\Facades\NederlandPostcode;

$addresses = NederlandPostcode::addresses()->get(
        postcode: '1118BN',
        number: null,
        addition: null,
        attributes: [
            AddressAttributesEnum::COORDINATES,
        ]
    );

foreach ($addresses as $address) {
    // process each address
}
```

### Fetching a single address

Same as above, but you can use the collection methods to work with the results:

```php
use Label84\NederlandPostcode\Facades\NederlandPostcode;

$addresses = NederlandPostcode::addresses()->get(
        postcode: '1118BN',
        number: 800,
        addition: null,
        attributes: [
            AddressAttributesEnum::COORDINATES,
        ]
    );

$addresses->first(); // get the first address from the collection
$addresses->count() === 1; // check if exactly one address was found
$addresses->isEmpty(); // check if no addresses were found
$addresses->isNotEmpty(); // check if addresses were found
$addresses->sole(); // gets the single address found or throws an exception if zero or multiple addresses found
```

## Error Handling

The package throws a `NederlandPostcodeException` for any errors encountered during the API request. You can catch this exception to handle errors gracefully:

```php
use Label84\NederlandPostcode\Exceptions\NederlandPostcodeException;

try {
    $addresses = NederlandPostcode::addresses()->get(
        postcode: 'INVALID',
        number: 123,
        addition: null,
    );
} catch (NederlandPostcodeException $exception) {
    // handle error
}
```

## Contributing

```bash
./vendor/bin/phpstan analyse
```

```bash
./vendor/bin/pint
```

## License

[MIT](https://opensource.org/licenses/MIT)
