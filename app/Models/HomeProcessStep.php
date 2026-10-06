<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeProcessStep extends Model
{
    protected $fillable = [
        'title', 'description', 'color', 'sort_order', 'is_active',
    ];

    protected $casts = [
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