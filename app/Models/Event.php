<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasUuid;

    protected $fillable = [
        'title', 'slug', 'description', 'category_id', 'author_id',
        'start_date', 'end_date', 'location', 'featured_image',
        'is_published', 'is_featured', 'max_attendees', 'current_attendees',
        'registration_required', 'registration_url', 'speaker',
    ];

    protected function casts(): array
    {
        return [
            'title' => 'array',
            'description' => 'array',
            'location' => 'array',
            'speaker' => 'array',
            'start_date' => 'datetime',
            'end_date' => 'datetime',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
            'registration_required' => 'boolean',
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

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function registrations()
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>=', now())->orderBy('start_date');
    }

    public function scopePast($query)
    {
        return $query->where('start_date', '<', now())->orderByDesc('start_date');
    }

    public function isUpcoming(): bool
    {
        return $this->start_date->isFuture();
    }

    public function isFull(): bool
    {
        return $this->max_attendees && $this->current_attendees >= $this->max_attendees;
    }
}
