<?php

namespace Reinbier\LaravelHoliday\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Reinbier\LaravelHoliday\Models\Holiday;

class GenerateHolidays extends Command
{
    public $signature = 'holiday:generate';

    public $description = 'Generates holidays for the current and next year.';

    public function handle(): int
    {
        $current_year = now()->year;

        $holiday = Holiday::firstOrCreate([
            'year' => $current_year,
        ], [
            'days' => collect(Carbon::getYearHolidays($current_year))->keys(),
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
            'days' => collect(Carbon::getYearHolidays($next_year))->keys(),
        ]);

        if ($holiday->wasRecentlyCreated) {
            $this->info('Holidays were generated for the next year!');
        } else {
            $this->warn('Holidays already exist for the next year!');
        }

        return self::SUCCESS;
    }
}