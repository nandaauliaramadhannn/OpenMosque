<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    use HasUuid;

    protected $fillable = [
        'service_id', 'name', 'email', 'phone', 'message',
        'preferred_date', 'preferred_time', 'status', 'admin_notes',
    ];

    protected function casts(): array
    {
        return [
            'preferred_date' => 'date',
        ];
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
