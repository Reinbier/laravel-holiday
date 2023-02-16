<?php

namespace Reinbier\LaravelHoliday\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Reinbier\LaravelHoliday\LaravelHoliday
 */
class LaravelHoliday extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-holiday';
    }
}
