<?php

use Carbon\Carbon;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Reinbier\LaravelHoliday\Models\Holiday;
use Reinbier\LaravelHoliday\Tests\TestCase;

uses(TestCase::class, LazilyRefreshDatabase::class)->in(__DIR__);

function freshHoliday($year = null): Holiday
{
    $year ??= now()->year;

    $holiday = Holiday::factory()->create(['year' => $year]);

    Carbon::setHolidaysRegion(config('holiday.locale'));

    $holiday->update([
        'days' => collect(Carbon::getYearHolidays($holiday->year))->map->format('Y-m-d'),
    ]);

    return $holiday;
}
