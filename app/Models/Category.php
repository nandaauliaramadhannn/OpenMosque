<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasUuid;

    protected $fillable = [
        'name', 'slug', 'type', 'color', 'icon', 'sort_order', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'name' => 'array',
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

    public function announcements()
    {
        return $this->hasMany(Announcement::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type)->where('is_active', true)->orderBy('sort_order');
    }
}
