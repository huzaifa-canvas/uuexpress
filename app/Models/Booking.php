<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'name', 'email', 'phone', 'service_type',
        'pickup_address', 'dropoff_address',
        'pickup_date', 'pickup_time', 'notes', 'status',
        'amount', 'payment_status', 'payment_intent_id',
    ];

    protected $casts = [
        'pickup_date' => 'date',
        'amount' => 'decimal:2',
    ];
}
