<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerMetadata extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'session_id',
        'customer_id',
        'registration_date',
        'consent_given',
        'geolocation',
        'digital_trace',
        'browser_language',
        'source',
        'suspected_bot',
        'bot_score',
        'blocked',
        'finalized'
    ];

    protected $casts = [
        'digital_trace'    => 'array',
        'browser_language' => 'string',
        'source'           => 'string',
        'geolocation'      => 'array',
        'consent_given'    => 'boolean',
        'registration_date'=> 'datetime',
        'suspected_bot'    => 'boolean',
        'bot_score'        => 'integer',
        'blocked'          => 'boolean',
        'finalized'        => 'boolean',
    ];

    /**
     * Normalización de arrays para evitar errores si llegan corruptos.
     */
    public function setGeolocationAttribute($value)
    {
        $this->attributes['geolocation'] = is_array($value)
            ? json_encode($value)
            : json_encode([]);
    }

    public function setDigitalTraceAttribute($value)
    {
        $this->attributes['digital_trace'] = is_array($value)
            ? json_encode($value)
            : json_encode([]);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}

