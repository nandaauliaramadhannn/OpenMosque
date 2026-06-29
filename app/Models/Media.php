<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasUuid;

    protected $table = 'media';

    protected $fillable = [
        'filename', 'path', 'disk', 'mime_type', 'size',
        'alt_text', 'caption', 'collection',
        'mediable_type', 'mediable_id', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'alt_text' => 'array',
            'caption' => 'array',
        ];
    }

    public function mediable()
    {
        return $this->morphTo();
    }

    public function getUrl(): string
    {
        return asset('storage/' . $this->path);
    }

    public function scopeCollection($query, string $collection)
    {
        return $query->where('collection', $collection)->orderBy('sort_order');
    }
}
