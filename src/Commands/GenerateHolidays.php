<?php

namespace Reinbier\LaravelHoliday\Commands;

use Carbon\Carbon;
use Cmixin\BusinessDay;
use Illuminate\Console\Command;
use Reinbier\LaravelHoliday\Models\Holiday;

class GenerateHolidays extends Command
{
    public $signature = 'holiday:generate';

    public $description = 'Generates holidays for the current and next year.';

    public function handle(): int
    {
        // enable business day plugin for Carbon, which also provides the holidays
        BusinessDay::enable(\Illuminate\Support\Carbon::class);
        $locale = config('holiday.locale', 'nl');

        Carbon::setHolidaysRegion($locale);

        $current_year = now()->year;

        $holiday = Holiday::firstOrCreate([
            'year' => $current_year,
        ], [
            'days' => collect(Carbon::getYearHolidays($current_year))->map(fn ($item, $key) => ['name' => $item->getHolidayName(), 'date' => $item->format('Y-m-d')])->values(),
        ]);

        $next_year = now()->addYear()->year;

        if ($holiday->wasRecentlyCreated) {
            $this->info('Holidays were generated for the current year!');
        } else {
            $this->warn('Holidays already exist for the current year!');
        }

        $holiday = Holiday::firstOrCreate([
            'year' => $next_year,
        ], [
            'days' => collect(Carbon::getYearHolidays($next_year))->map(fn ($item, $key) => ['name' => $item->getHolidayName(), 'date' => $item->format('Y-m-d')])->values(),
        ]);

        if ($holiday->wasRecentlyCreated) {
            $this->info('Holidays were generated for the next year!');
        } else {
            $this->warn('Holidays already exist for the next year!');
        }

        return self::SUCCESS;
    }
}
