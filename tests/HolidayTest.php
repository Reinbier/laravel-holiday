<?php

use Carbon\Carbon;
use Reinbier\LaravelHoliday\Models\Holiday;

it('can create a Holiday model', function () {
    $holiday = Holiday::factory()->create();

    expect($holiday)
        ->year->toBe(now()->year)
        ->and(Holiday::count())->toBe(1);
});

it('can add holidays by locale', function () {
    $holiday = Holiday::factory()->create();

    $holiday->update([
        'days' => Carbon::getYearHolidays($holiday->year),
    ]);

    expect($holiday)
        ->days->toBeArray()->toHaveKeys(['new-year', 'easter', 'pentecost']);
});
