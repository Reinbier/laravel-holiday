<?php

use Reinbier\LaravelHoliday\Facades\LaravelHoliday;
use Reinbier\LaravelHoliday\Models\Holiday;

it('can create a Holiday model', function () {
    $holiday = Holiday::factory()->create();

    expect($holiday)
        ->year->toBe(now()->year)
        ->and(Holiday::all())->toHaveCount(1);
});

it('can add holidays by locale', function () {
    $holiday = freshHoliday(2005);

    // check for Dutch liberation-day which happens every five years
    expect($holiday)
        ->days->toBeCollection()->toHaveKeys(['new-year', 'easter', 'liberation-day']);
});

it('can add extra holidays', function () {
    $holiday = freshHoliday(2000);

    $holiday->update([
        'extra_days' => [['date' => '2000-07-06']],
    ]);

    expect($holiday)
        ->year->toBe(2000)
        ->and($holiday->getHolidays())
        ->toHaveKey('2000-07-06');
});

it('can retrieve holidays from the service container', function () {
    $holiday = freshHoliday();

    $holidays = LaravelHoliday::forYear($holiday->year)->getHolidays();

    expect($holidays)
        ->toBeCollection()->toHaveKeys(['new-year', 'easter', 'pentecost']);
});

it('can generate holidays with the command', function () {
    Artisan::call('holiday:generate');

    $holiday = Holiday::year(now()->year)->first();
    $holiday_next_year = Holiday::year(now()->addYear()->year)->first();

    expect(Holiday::all())
        ->toHaveCount(2)
        ->and($holiday)
        ->days->toBeCollection()->toHaveKeys(['new-year', 'easter', 'pentecost'])
        ->and($holiday_next_year)
        ->days->toBeCollection()->toHaveKeys(['new-year', 'easter', 'pentecost']);
});
