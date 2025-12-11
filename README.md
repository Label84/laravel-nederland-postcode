# Nederland Postcode Laravel

![Nederland Postcode API](./docs/nederlandpostcodeapi.png)

Nederland Postcode Laravel makes it easy to integrate Dutch address validations into your Laravel application using the [Nederland Postcode API](https://nederlandpostcode.nl).

This is a Laravel wrapper for the [Nederland Postcode PHP](https://github.com/Label84/php-nederland-postcode) package.

Register for free to obtain a **test API key** at [nederlandpostcode.nl](https://nederlandpostcode.nl) to get started.

- [Requirements](#requirements)
- [Installation](#installation)
- [Usage](#usage)
  - [Address Endpoint](#address-endpoint)
    - [Single Address](#single-address)
    - [Multiple Addresses](#multiple-addresses)
  - [Quota Endpoint](#quota-endpoint)
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
php artisan vendor:publish --provider="Label84\NederlandPostcode\Laravel\NederlandPostcodeServiceProvider" --tag="config"
```

Add your API key to your `.env` file:

```env
NEDERLAND_POSTCODE_API_KEY="your_api_key_here"
```

## Usage

### Address Endpoint

The address endpoint allows you to fetch address information from the Nederland Postcode API.

You can find addresses using either the `find` method for a single address or the `list` method for multiple addresses. When you provide only the `postcode`, the `list` method will return all addresses associated with that postcode.

The following optional attributes can be requested to be included in the response:

- `coordinates`: Includes latitude and longitude of the address.

#### Single Address

To fetch a single address for a given postcode and house number, you can use the `find` method.

The `postcode` and `number` parameters are required to fetch a single address.

```php
use Label84\NederlandPostcode\Laravel\Facades\NederlandPostcode;

$address = NederlandPostcode::find(
        postcode: '1118BN',
        number: 800,
        addition: null,
        attributes: [
            'coordinates',
        ]
    );
```

This will return an `Address` object like this:

```php
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
```

When no address is found for the given postcode and number, an `AddressNotFoundException` is thrown. If multiple addresses are found, a `MultipleAddressesFoundException` is thrown.

#### Multiple Addresses

To fetch multiple addresses for a given postcode, you can use the `list` method.

The `postcode` parameter is required. The `number` and `addition` parameters are optional.

```php
use Label84\NederlandPostcode\Laravel\Facades\NederlandPostcode;

$addresses = NederlandPostcode::list(
        postcode: '1118BN',
        number: null,
        addition: null,
        attributes: [
            'coordinates',
        ]
    );
```

This will return an `AddressCollection` object like this:

```php
AddressCollection {
    items: [
        Address {
            postcode: "1118BN",
            number: 701,
            street: "Schiphol Boulevard",
            city: "Schiphol",
            municipality: "Haarlemmermeer",
            province: "Noord-Holland",
            coordinates: Coordinates {
                latitude: 52.30703569036619,
                longitude: 4.755174782205992
            }
        },
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

### Quota Endpoint

The quota endpoint allows you to check your current API usage and limits. This endpoint does not increase your usage quota.

> [!NOTE]
> Values may lag behind the actual usage. They’re cached for up to five minutes, so the `used` and `limit` numbers might not be fully up-to-date.

```php
use Label84\NederlandPostcode\Laravel\Facades\NederlandPostcode;

$quota = NederlandPostcode::usage();
```

This will return an `Quota` object like this:

```php
Quota {
    used: 1500,
    limit: 10000,
}
```

## Error Handling

The package throws a `NederlandPostcodeException` for any errors encountered during the API request. You can catch this exception to handle errors gracefully:

```php
use Label84\NederlandPostcode\Laravel\Exceptions\NederlandPostcodeException;

try {
    $addresses = NederlandPostcode::find(
        postcode: 'INVALID',
        number: 123,
        addition: null,
    );
} catch (NederlandPostcodeException $exception) {
    // handle error
}
```

When calling the `find` method, if no address is found, an `AddressNotFoundException` is thrown. If multiple addresses are found, a `MultipleAddressesFoundException` is thrown.

When a network or HTTP error occurs during the API request, a `NederlandPostcodeRequestException` is thrown, which wraps the original `RequestException`.

## Contributing

```bash
./vendor/bin/phpstan analyse
```

```bash
./vendor/bin/pint
```

```bash
./vendor/bin/phpunit
```

## License

[MIT](https://opensource.org/licenses/MIT)
