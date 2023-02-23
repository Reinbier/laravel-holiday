<?php

namespace Reinbier\LaravelHoliday;

use Cmixin\BusinessDay;
use Illuminate\Support\Carbon;
use Reinbier\LaravelHoliday\Commands\GenerateHolidays;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelHolidayServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-holiday')
            ->hasConfigFile()
            ->hasMigration('create_laravel-holiday_table')
            ->hasCommand(GenerateHolidays::class);
    }

    public function packageRegistered()
    {
        $this->app->singleton('laravel-holiday', function ($app) {
            return new LaravelHoliday(now()->year);
        });
    }

    public function packageBooted()
    {
        // enable business day plugin for Carbon
        BusinessDay::enable(Carbon::class);
    }
}
