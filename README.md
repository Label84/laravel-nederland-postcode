# Laravel Nederland Postcode

`laravel-nederland-postcode` makes it easy to integrate Dutch postcode lookups into your Laravel application using the [Nederland Postcode API](https://nederlandpostcode.nl).

For more details about the API, visit the [Nederland Postcode API documentation](https://nederlandpostcode.nl).

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

You can retrieve addresses by postcode and house number using the `addresses` endpoint.

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

This will return a collection of addresses matching the provided postcode and house number. The `number` and `addition` parameters are optional.

The `attributes` parameter lets you include additional data in the response, e.g., `AddressAttributesEnum::COORDINATES` to get latitude and longitude.

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

You can then use collection methods to work with the results:

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
