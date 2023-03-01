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

    Carbon::setHolidaysRegion('nl');

    $holiday->update([
        'days' => collect(Carbon::getYearHolidays($holiday->year))->map(fn ($item, $key) => ['name' => $item->getHolidayName(), 'date' => $item->format('Y-m-d')])->values(),
    ]);

    return $holiday;
}
