<?php

namespace Reinbier\LaravelHoliday\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Reinbier\LaravelHoliday\Models\Holiday;

class HolidayFactory extends Factory
{
    protected $model = Holiday::class;

    public function definition(): array
    {
        return [
            'year' => now()->year,
            'days' => [],
        ];
    }
}
