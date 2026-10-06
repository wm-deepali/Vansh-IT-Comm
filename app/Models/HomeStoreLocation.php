<?php

namespace App\Models;

use App\Models\Concerns\ResolvesLinks;
use Illuminate\Database\Eloquent\Model;

class HomeStoreLocation extends Model
{
    use ResolvesLinks;

    protected $fillable = [
        'icon', 'color', 'badge', 'title', 'address', 'phone', 'details',
        'button_text', 'button_route', 'button_url', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'details'   => 'array',
        'is_active' => 'boolean',
    ];

    public function scopeActive($q)
    {
        return $q->where('is_active', true);
    }

    public function scopeOrdered($q)
    {
        return $q->orderBy('sort_order')->orderBy('id');
    }
}