<?php

namespace Reinbier\LaravelHoliday;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Reinbier\LaravelHoliday\Models\Holiday;

class LaravelHoliday
{
    private ?Holiday $holiday;

    /**
     * Constructor.
     */
    public function __construct(int $year)
    {
        $this->setHoliday($year);

        $this->setupCarbon();
    }

    /**
     * Helper method for setting the Holiday model in a fluent way.
     */
    public function forYear(int $year): self
    {
        $this->setHoliday($year);

        $this->setupCarbon();

        return $this;
    }

    /**
     * Setup Carbon by adding all registered holidays.
     * If there's no holiday model present, it sets the default holidays
     * for the current locale.
     */
    public function setupCarbon(): self
    {
        $locale = config('holiday.locale', 'nl');

        Carbon::setHolidaysRegion($locale);

        if (! is_null($this->holiday)) {
            Carbon::setHolidays(
                $locale,
                $this->getHolidays()->pluck('date')->all()
            );
        }

        return $this;
    }

    /**
     * Returns the holidays as a collection.
     */
    public function getHolidays(): Collection
    {
        return $this->holiday?->days ?? collect();
    }

    /**
     * Retrieve future holidays from this year up until
     * a given year as a single collection.
     */
    public function getFutureHolidays(int $until_year = null): Collection
    {
        // when left null, make sure to fetch all holidays until way up in the future
        if (is_null($until_year)) {
            $until_year = now()->addYears(100)->year;
        }

        return Holiday::where('year', '<=', $until_year)->pluck('days')->flatten(1);
    }

    /**
     * Add one or more holidays. When a string or array of strings is given, make
     * sure to set the proper format as well.
     */
    public function addHoliday(Carbon|string $holiday, string $name = null, string $format = 'Y-m-d'): self
    {
        if ($this->model()) {
            // Sanitize the input, we need to make sure we can work with the provided value
            if (is_string($holiday)) {
                $holiday = Carbon::createFromFormat($format, $holiday);
            }

            $model = $this->model();
            $model->days->push(['name' => $name, 'date' => $holiday->format('Y-m-d')]);
            $model->save();

            // refresh both the Holiday and Carbon
            $this->refresh();
        }

        return $this;
    }

    /**
     * Returns the underlying model.
     */
    public function model(): ?Holiday
    {
        return $this->holiday;
    }

    /**
     * Refreshes both the Holiday model and the Carbon instance
     * to set the proper holidays.
     */
    private function refresh(): void
    {
        $this->holiday = $this->holiday->fresh();

        $this->setupCarbon();
    }

    /**
     * Sets the Holiday model based on the given year.
     */
    public function setHoliday(int $year): void
    {
        if (Schema::hasTable(config('holiday.table_name'))) {
            $this->holiday = Holiday::year($year)->first();
        } else {
            $this->holiday = null;
        }
    }
}
