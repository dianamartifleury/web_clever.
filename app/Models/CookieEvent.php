<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CookieEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_type',
        'data',
        'ip',
        'user_agent',
        'session_id',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function metadata(): BelongsTo
    {
        return $this->belongsTo(CustomerMetadata::class, 'session_id', 'session_id');
    }
}
