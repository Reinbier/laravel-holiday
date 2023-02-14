<?php

namespace Reinbier\LaravelHoliday;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Reinbier\LaravelHoliday\Commands\LaravelHolidayCommand;

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
            ->hasMigration()
            ->hasCommand(LaravelHolidayCommand::class);
    }
}
