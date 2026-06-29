<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class PrayerSetting extends Model
{
    use HasUuid;

    protected $fillable = [
        'calculation_method', 'asr_method', 'adjustments',
        'iqamah_offsets', 'iqamah_fixed', 'use_iqamah_fixed',
        'jumuah_time', 'jumuah_khutbah_time', 'is_auto_calculated',
    ];

    protected function casts(): array
    {
        return [
            'adjustments' => 'array',
            'iqamah_offsets' => 'array',
            'iqamah_fixed' => 'array',
            'use_iqamah_fixed' => 'boolean',
            'is_auto_calculated' => 'boolean',
        ];
    }
}
