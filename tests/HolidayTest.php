<?php

use Carbon\Carbon;
use Reinbier\LaravelHoliday\Facades\LaravelHoliday;
use Reinbier\LaravelHoliday\Models\Holiday;

it('can create a Holiday model', function () {
    $holiday = Holiday::factory()->create();

    expect($holiday)
        ->year->toBe(now()->year)
        ->and(Holiday::all())->toHaveCount(1);
});

it('can add holidays by locale', function () {
    $holiday = Holiday::factory()->create();

    $holiday->update([
        'days' => Carbon::getYearHolidays($holiday->year),
    ]);

    expect($holiday)
        ->days->toBeCollection()->toHaveKeys(['new-year', 'easter', 'pentecost']);
});

it('can retrieve holidays from the service container', function () {
    $holiday = Holiday::factory()->create();

    $holiday->update([
        'days' => Carbon::getYearHolidays($holiday->year),
    ]);

    $holidays = LaravelHoliday::forYear($holiday->year)->getHolidays();

    expect($holidays)
        ->toBeCollection()->toHaveKeys(['new-year', 'easter', 'pentecost']);
});
