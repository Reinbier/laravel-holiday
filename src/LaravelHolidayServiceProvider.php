<?php

namespace Reinbier\LaravelHoliday;

use Carbon\Carbon;
use Cmixin\BusinessDay;
use Reinbier\LaravelHoliday\Commands\LaravelHolidayCommand;
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
            ->hasViews()
            ->hasMigration('create_laravel-holiday_table')
            ->hasCommand(LaravelHolidayCommand::class);
    }

    public function boot()
    {
        parent::boot();

        // enable business day calculator plugin for Carbon
        BusinessDay::enable(\Illuminate\Support\Carbon::class);
        Carbon::setHolidaysRegion(config('app.locale'));
    }
}
