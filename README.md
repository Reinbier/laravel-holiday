# Holidays in Laravel, the right way.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/reinbier/laravel-holiday.svg?style=flat-square)](https://packagist.org/packages/reinbier/laravel-holiday)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/reinbier/laravel-holiday/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/reinbier/laravel-holiday/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/reinbier/laravel-holiday/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/reinbier/laravel-holiday/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/reinbier/laravel-holiday.svg?style=flat-square)](https://packagist.org/packages/reinbier/laravel-holiday)

This packages helps by providing a Holiday model in your project with all 
the holidays for a specific year.

These holidays are then injected into Carbon via the 
[BusinessDay](https://github.com/kylekatarnls/business-day) 
package. You can then simply see if a given Carbon instance 
represents a holiday, via `$carbon->isHoliday()`.

## Use cases

For instance, when managing employees' timesheet. When filling in
the current week with hours you can show when a day is a holiday, 
so they would not have to fill in their hours for that day.

Another example would be when you want to show your store's opening hours.
When echoing your opening hours for each day, you can check whether the
given date is a holiday and say that you're closed this day.

## Installation

You can install the package via composer:

```bash
composer require reinbier/laravel-holiday
```

You should publish and run the migrations:

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
     * The name of the table to use. You can adjust this to suit your needs.
     */
    'table_name' => 'holidays',

    /**
     * If you want to use a different locale to generate holidays for,
     * you can set it here. If left 'null' then locale will be applied
     * from your `app.locale` value as a default.
     */
    'locale' => null,
    
];
```

## Usage

To generate holidays for the current and next year, execute the command.

```bash
php artisan holiday:generate
```

Subsequently, you could schedule this command to run yearly so your table will always hold data when working with the Holiday model.

To do that, place the following line into your Console/Kernel.php 'schedule' method:

```php

    protected function schedule(Schedule $schedule)
    {
        // ...
        
        $schedule->command('holiday:generate')->yearly();
    }
```

### Using the Facade

The `LaravelHoliday` Facade gets automatically registered in the service container.
The facade is a singleton and will hold the current year's Holiday model.
It will set global holidays throughout your application so that you can check 
any date for whether it's treated as a holiday according to your model.

The facade also provides you with a couple of methods:

```php
use Reinbier\LaravelHoliday\Facades\LaravelHoliday;

// The Holiday model of the current year
$holiday = LaravelHoliday::model();

// All holiday-dates in a Collection
$holidays = LaravelHoliday::getHolidays(); 

// Set the Holiday model and chain methods
LaravelHoliday::forYear(2023)->getHolidays();
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

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
