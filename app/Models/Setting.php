<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasUuid;

    protected $fillable = [
        'key', 'value', 'group', 'type', 'label', 'description',
    ];

    protected function casts(): array
    {
        return [
            'value' => 'array',
        ];
    }

    /**
     * Get a setting value by key.
     */
    public static function getValue(string $key, mixed $default = null): mixed
    {
        $setting = static::where('key', $key)->first();

        if (!$setting) {
            return $default;
        }

        $value = $setting->value;

        // If value is a single-element array with numeric key, unwrap it
        if (is_array($value) && count($value) === 1 && isset($value[0])) {
            return $value[0];
        }

        return $value ?? $default;
    }

    /**
     * Set a setting value by key.
     */
    public static function setValue(string $key, mixed $value, ?string $group = null): static
    {
        $setting = static::firstOrNew(['key' => $key]);

        // Wrap scalar values in array for JSON column
        $setting->value = is_array($value) ? $value : [$value];

        if ($group) {
            $setting->group = $group;
        }

        $setting->save();

        return $setting;
    }

    /**
     * Get all settings in a group.
     */
    public static function getGroup(string $group): array
    {
        return static::where('group', $group)
            ->pluck('value', 'key')
            ->toArray();
    }
}
