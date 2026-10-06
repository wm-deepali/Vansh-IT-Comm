<?php
// app/Models/AboutStat.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutStat extends Model
{
    protected $fillable = ['value', 'label', 'color', 'sort_order', 'status'];

    protected $casts = ['status' => 'boolean'];

    public function scopeActive($query)
    {
        return $query->where('status', true)->orderBy('sort_order')->orderBy('id');
    }
}