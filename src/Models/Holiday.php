<?php

namespace Reinbier\LaravelHoliday\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = ['year', 'days', 'extra_days'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'days' => 'array',
        'extra_days' => 'array',
    ];

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return config('holiday.table_name', parent::getTable());
    }

    /*
     |--------------------------------------------------------------------------
     | ATTRIBUTES
     |--------------------------------------------------------------------------
     */

    public function getHolidaysAttribute()
    {
        $holidays = collect(Carbon::getYearHolidays($this->year))
            ->filter(function ($item, $key) {
                return in_array($key, $this->days);
            })
            ->map(function ($item) {
                return Carbon::create($item)->format('Y-m-d');
            });

        return $holidays->merge(collect($this->extra_days)->pluck('date'));
    }

    /*
     |--------------------------------------------------------------------------
     | SCOPES
     |--------------------------------------------------------------------------
     */

    public function scopeYear($query, $year)
    {
        return $query->where('year', $year);
    }
}
