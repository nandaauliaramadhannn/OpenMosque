<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasUuid;

    protected $table = 'staff';

    protected $fillable = [
        'name', 'role_title', 'bio', 'photo_path',
        'email', 'phone', 'sort_order', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'name' => 'array',
            'role_title' => 'array',
            'bio' => 'array',
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

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
