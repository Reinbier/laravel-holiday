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
        $locale = config('holiday.locale');

        if (is_null($this->holiday)) {
            Carbon::setHolidaysRegion($locale);
        } else {
            Carbon::setHolidays(
                config('holiday.locale', 'nl'),
                $this->getHolidays()->all()
            );
        }

        return $this;
    }

    /**
     * Returns the holidays as a collection. Also, merging the
     * extra days (if any) along the way.
     */
    public function getHolidays(): ?Collection
    {
        return $this->holiday?->getHolidays();
    }

    /**
     * Returns the underlying model.
     */
    public function model(): ?Holiday
    {
        return $this->holiday;
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
