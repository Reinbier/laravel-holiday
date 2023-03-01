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
    $holiday = freshHoliday(2005);

    // check for Dutch liberation-day which happens every five years
    expect($holiday)
        ->days->toBeCollection()
        ->toContain(['name' => 'Liberation Day', 'date' => '2005-05-05']);

    $holiday = freshHoliday(2006);

    // check for Dutch liberation-day which happens every five years
    expect($holiday)
        ->days->toBeCollection()
        ->not->toContain('liberation-day', '2006-05-05');
});

it('can add holidays', function () {
    $holiday = freshHoliday(2000);

    LaravelHoliday::forYear(2000)->addHoliday('2000-03-04', 'boss-birthday');

    expect($holiday)
        ->year->toBe(2000)
        ->and($holiday->fresh())
        ->days->last()
        ->toHaveKey('name', 'boss-birthday')
        ->toHaveKey('date', '2000-03-04');
});

it('can check if a given date is a holiday', function () {
    freshHoliday(2000);

    LaravelHoliday::forYear(2000)->addHoliday('2000-03-04');

    expect(Carbon::make('2000-03-04')->isHoliday())
        ->toBeTrue()
        ->and(Carbon::make('2000-03-05')->isHoliday())
        ->toBeFalse()
        ->and(Carbon::make('2000-12-25')->isHoliday())
        ->toBeTrue();
});

it('can retrieve holidays from the service container', function () {
    $holiday = freshHoliday();

    $holidays = LaravelHoliday::forYear($holiday->year)->addHoliday($holiday->year.'-06-07', 'june-seventh')->getHolidays();

    expect($holidays)
        ->toBeCollection()
        ->toContain(['name' => 'Christmas', 'date' => $holiday->year.'-12-25'])
        ->toContain(['name' => 'june-seventh', 'date' => $holiday->year.'-06-07']);
});

it('can generate holidays with the command', function () {
    Artisan::call('holiday:generate');

    $holiday = Holiday::year(now()->year)->first();
    $holiday_next_year = Holiday::year(now()->addYear()->year)->first();

    expect(Holiday::all())
        ->toHaveCount(2)
        ->and($holiday)->days
        ->toContain(['name' => 'New Year', 'date' => now()->startOfYear()->format('Y-m-d')])
        ->and($holiday_next_year)->days
        ->toContain(['name' => 'New Year', 'date' => now()->addYear()->startOfYear()->format('Y-m-d')]);
});
