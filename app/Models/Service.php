<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name', 'slug', 'image', 'desc', 'price', 'tint',
        'intro', 'detail_heading', 'detail_body', 'features', 'cta_heading',
        'is_active', 'sort_order',
    ];

    protected $casts = [
        'features' => 'array',
        'is_active' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /** Turn a service name into its slug, e.g. "Local Delivery" -> "local-delivery". */
    public static function slugFor(string $name): string
    {
        return \Illuminate\Support\Str::slug($name);
    }
}
