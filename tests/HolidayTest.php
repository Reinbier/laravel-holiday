<?php

use Carbon\Carbon;
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

//    var_dump(\Reinbier\LaravelHoliday\Facades\LaravelHoliday::getHolidays()->all());

    expect($holiday)
        ->days->toBeArray()->toHaveKeys(['new-year', 'easter', 'pentecost']);
});
