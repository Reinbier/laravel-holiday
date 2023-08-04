# Custom holidays in Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/reinbier/laravel-holiday.svg?style=flat-square)](https://packagist.org/packages/reinbier/laravel-holiday)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/reinbier/laravel-holiday/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/reinbier/laravel-holiday/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/reinbier/laravel-holiday/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/reinbier/laravel-holiday/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/reinbier/laravel-holiday.svg?style=flat-square)](https://packagist.org/packages/reinbier/laravel-holiday)

This package helps by providing a Holiday model in your project with all 
the holidays for a specific year. 

By storing them in the database and automatically injected into Carbon via the 
[BusinessDay](https://github.com/kylekatarnls/business-day) 
package, you can simply see if a given Carbon instance 
represents a holiday, via `$carbon->isHoliday()`.

The benefits of the model are that you can easily add your own holidays.
On top of that, the package can generate holidays for the current locale.

## Use cases

An example would be when you want to show your store's opening hours.
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
     * you can set it here. For now, a sensible default is set.
     */
    'locale' => config('app.locale', 'nl'),

    /**
     * When true, sets the holidays for Carbon in the service container.
     */
    'enable_carbon' => false,
    
];
```

## Usage

To generate local holidays for the current and next year, execute the command.

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
LaravelHoliday::forYear(2023)
    ->addHoliday('2023-06-07', 'boss-birthday')
    ->getHolidays();

// Simply add multiple holidays by chaining
LaravelHoliday::forYear(2023)
    ->addHoliday('2023-06-07', 'boss-birthday')
    ->addHoliday('2023-10-10', 'anniversary')
    -> ...
```

### Future holidays
If you don't want to be limited to only the current year's holidays, you can
fetch all future holidays as well using the helper method on the facade: `getFutureHolidays()`.
```php
use Reinbier\LaravelHoliday\Facades\LaravelHoliday;

$future_holidays = LaravelHoliday::getFutureHolidays();
// You may optionally specify a year, until when to retrieve holidays 
$future_holidays = LaravelHoliday::getFutureHolidays(2035); 
```

### Enable holidays in Carbon

The package can automatically apply your stored holidays to Carbon instances, 
so that, whenever you need to check a date to be a holiday, you can 
call `->isHoliday()` on that Carbon instance.

This setting is disabled by default. To enable this, set the value in the config `holiday.php`.

```php
'enable_carbon' => true,
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
