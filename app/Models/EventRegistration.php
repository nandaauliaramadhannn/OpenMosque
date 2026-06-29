<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class EventRegistration extends Model
{
    use HasUuid;

    protected $fillable = [
        'event_id', 'name', 'email', 'phone', 'notes', 'status',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
