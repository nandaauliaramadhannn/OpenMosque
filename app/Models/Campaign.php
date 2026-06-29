<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasUuid;

    protected $fillable = [
        'title', 'description', 'goal_amount', 'current_amount',
        'start_date', 'end_date', 'featured_image', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'title' => 'array',
            'description' => 'array',
            'goal_amount' => 'decimal:2',
            'current_amount' => 'decimal:2',
            'start_date' => 'date',
            'end_date' => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function getTranslation(string $attribute, ?string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();
        $fallback = config('app.fallback_locale', 'en');
        $value = $this->getAttribute($attribute);
        if (!is_array($value)) return $value ?? '';
        return $value[$locale] ?? $value[$fallback] ?? $value[array_key_first($value)] ?? '';
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function getProgressPercentage(): float
    {
        if ($this->goal_amount <= 0) return 0;
        return min(100, round(($this->current_amount / $this->goal_amount) * 100, 1));
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
