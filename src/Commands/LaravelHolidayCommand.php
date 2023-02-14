<?php

namespace Reinbier\LaravelHoliday\Commands;

use Illuminate\Console\Command;

class LaravelHolidayCommand extends Command
{
    public $signature = 'laravel-holiday';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
