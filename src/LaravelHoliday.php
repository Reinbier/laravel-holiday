<?php

namespace Reinbier\LaravelHoliday;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Reinbier\LaravelHoliday\Models\Holiday;

class LaravelHoliday
{
    private ?Holiday $holiday;

    /**
     * Constructor
     */
    public function __construct(int $year)
    {
        $this->holiday = Holiday::year($year)->first();
    }

    /**
     * Setup Carbon by adding all registered holidays.
     * If there's no holiday model present, it sets the default holidays
     * for the current locale
     */
    public function setupCarbon(): void
    {
        $locale = config('holiday.locale') ?? config('app.locale', 'nl');

        if (is_null($this->holiday)) {
            Carbon::setHolidaysRegion($locale);
        } else {
            Carbon::setHolidays(
                config('holiday.locale') ?? config('app.locale', 'nl'),
                $this->getHolidays()->all()
            );
        }
    }

    /**
     * Returns the holidays as a collection.
     *
     * Because only the keys/names of the holidays are stored, a lookup to the actual
     * dates via Carbon is required. It then filters the collection according
     * to the stored keys and retrieves the corresponding dates. Also, merging the
     * extra days (if any) along the way.
     */
    public function getHolidays(): Collection
    {
        $holidays = collect(Carbon::getYearHolidays($this->holiday->year))
            ->filter(function ($item, $key) {
                return in_array($key, $this->holiday->days);
            })
            ->map(function ($item) {
                return Carbon::create($item)->format('Y-m-d');
            });

        return $holidays->merge(collect($this->holiday->extra_days)->pluck('date'));
    }

    /**
     * Returns the underlying model
     */
    public function model(): Holiday
    {
        return $this->holiday;
    }
}
