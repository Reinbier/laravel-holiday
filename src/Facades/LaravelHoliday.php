<?php

namespace Reinbier\LaravelHoliday\Facades;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use Reinbier\LaravelHoliday\Models\Holiday;

/**
 * @method void setHoliday(int $year)
 * @method self forYear(int $year)
 * @method self setupCarbon()
 * @method Holiday model()
 * @method Collection getHolidays()
 * @method self addHoliday(string|Carbon $holiday)
 *
 * @see \Reinbier\LaravelHoliday\LaravelHoliday
 */
class LaravelHoliday extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-holiday';
    }
}
