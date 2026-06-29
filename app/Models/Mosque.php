<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class Mosque extends Model
{
    use HasUuid;

    protected $fillable = [
        'name', 'description', 'mission', 'vision', 'history',
        'address', 'latitude', 'longitude',
        'phone', 'email', 'website', 'social_links',
        'logo_path', 'favicon_path', 'cover_image_path',
        'timezone', 'country_code', 'currency',
    ];

    protected function casts(): array
    {
        return [
            'name' => 'array',
            'description' => 'array',
            'mission' => 'array',
            'vision' => 'array',
            'history' => 'array',
            'social_links' => 'array',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
        ];
    }

    /**
     * Get translated attribute value.
     */
    public function getTranslation(string $attribute, ?string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();
        $fallback = config('app.fallback_locale', 'en');
        $value = $this->getAttribute($attribute);

        if (!is_array($value)) {
            return $value ?? '';
        }

        return $value[$locale] ?? $value[$fallback] ?? $value[array_key_first($value)] ?? '';
    }
}
