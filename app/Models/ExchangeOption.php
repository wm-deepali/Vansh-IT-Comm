<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExchangeOption extends Model
{
    protected $guarded = [];
    protected $casts = ['status' => 'boolean'];

    // Simple dropdowns edited as "Label | value" lines (no pricing data)
    public const TYPES = [
        'age'     => 'Device Age Options',
        'charger' => 'Charger Options',
    ];

    public function scopeActive($q)
    {
        return $q->where('status', 1)->orderBy('sort_order')->orderBy('id');
    }

    public function scopeOfType($q, string $type)
    {
        return $q->where('type', $type);
    }
}