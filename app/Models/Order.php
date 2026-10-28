<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'order_number', 'user_id', 'customer_name', 'email', 'phone',
        'address', 'city', 'postcode', 'notes',
        'subtotal', 'total', 'status', 'payment_status', 'payment_intent_id',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public static function generateNumber(): string
    {
        return 'UU-' . now()->format('ymd') . '-' . strtoupper(\Illuminate\Support\Str::random(5));
    }
}
