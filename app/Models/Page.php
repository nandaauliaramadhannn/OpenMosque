<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasUuid;

    protected $fillable = [
        'title', 'slug', 'body', 'template', 'featured_image',
        'is_published', 'show_in_menu', 'sort_order',
        'meta_title', 'meta_description',
    ];

    protected function casts(): array
    {
        return [
            'title' => 'array',
            'body' => 'array',
            'meta_title' => 'array',
            'meta_description' => 'array',
            'is_published' => 'boolean',
            'show_in_menu' => 'boolean',
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

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeInMenu($query)
    {
        return $query->where('show_in_menu', true)->orderBy('sort_order');
    }
}
