<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class PrayerTime extends Model
{
    use HasUuid;

    protected $fillable = [
        'date', 'fajr', 'sunrise', 'dhuhr', 'asr', 'maghrib', 'isha',
        'iqamah_fajr', 'iqamah_dhuhr', 'iqamah_asr', 'iqamah_maghrib', 'iqamah_isha',
        'is_manual', 'is_ramadan',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'is_manual' => 'boolean',
            'is_ramadan' => 'boolean',
        ];
    }

    /**
     * Get today's prayer times.
     */
    public static function today()
    {
        return static::where('date', today())->first();
    }

    /**
     * Get prayer times for a specific month.
     */
    public static function forMonth(int $year, int $month)
    {
        return static::whereYear('date', $year)
            ->whereMonth('date', $month)
            ->orderBy('date')
            ->get();
    }
}
