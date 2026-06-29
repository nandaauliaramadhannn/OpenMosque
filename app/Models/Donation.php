<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasUuid;

    protected $fillable = [
        'campaign_id', 'donor_name', 'donor_email', 'donor_phone',
        'amount', 'currency', 'type', 'payment_method', 'payment_reference',
        'transaction_id', 'status', 'is_anonymous', 'is_recurring', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'is_anonymous' => 'boolean',
            'is_recurring' => 'boolean',
        ];
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year);
    }
}
