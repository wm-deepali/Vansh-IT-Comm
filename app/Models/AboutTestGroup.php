<?php
// app/Models/AboutTestGroup.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutTestGroup extends Model
{
    protected $fillable = [
        'title', 'subtitle', 'icon', 'color',
        'footer_icon', 'footer_label', 'footer_value',
        'sort_order', 'status',
    ];

    protected $casts = ['status' => 'boolean'];

    public function items()
    {
        return $this->hasMany(AboutTestItem::class)->orderBy('sort_order')->orderBy('id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', true)->orderBy('sort_order')->orderBy('id');
    }
}