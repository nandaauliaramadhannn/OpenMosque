<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasUuid;

    protected $fillable = [
        'user_id', 'action', 'model_type', 'model_id',
        'description', 'changes', 'ip_address',
    ];

    protected function casts(): array
    {
        return [
            'changes' => 'array',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Log an activity.
     */
    public static function log(
        string $action,
        ?string $description = null,
        ?Model $model = null,
        ?array $changes = null
    ): static {
        return static::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'model_type' => $model ? get_class($model) : null,
            'model_id' => $model?->getKey(),
            'description' => $description,
            'changes' => $changes,
            'ip_address' => request()->ip(),
        ]);
    }
}
