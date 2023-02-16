# Holidays in Laravel, the right way.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/reinbier/laravel-holiday.svg?style=flat-square)](https://packagist.org/packages/reinbier/laravel-holiday)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/reinbier/laravel-holiday/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/reinbier/laravel-holiday/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/reinbier/laravel-holiday/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/reinbier/laravel-holiday/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/reinbier/laravel-holiday.svg?style=flat-square)](https://packagist.org/packages/reinbier/laravel-holiday)

This packages helps by providing a Holiday model in your project with all the holidays for a specific year.


## Installation

You can install the package via composer:

```bash
composer require reinbier/laravel-holiday
```

You should to publish and run the migrations:

```bash
php artisan vendor:publish --tag="holiday-migrations"
php artisan migrate
```

Optionally, you can publish the config file with:

```bash
php artisan vendor:publish --tag="holiday-config"
```

This is the contents of the published config file:

```php
return [

    /**
     * The name of the table to use
     */
    'table_name' => 'holidays',
    
];
```

## Usage

```php

```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Security Vulnerabilities

If you discover any security related issues, please email support@reinbier.nl instead of using the issue tracker.

## Credits

- [reinbier](https://github.com/Reinbier)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
