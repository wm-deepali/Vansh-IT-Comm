<?php
// app/Models/RepairCategory.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RepairCategory extends Model
{
    protected $fillable = ['eyebrow', 'title', 'sort_order', 'status'];

    protected $casts = ['status' => 'boolean'];

    public function services()
    {
        return $this->hasMany(RepairService::class)->orderBy('sort_order')->orderBy('id');
    }

    public function activeServices()
    {
        return $this->hasMany(RepairService::class)->where('status', true)->orderBy('sort_order')->orderBy('id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', true)->orderBy('sort_order')->orderBy('id');
    }
}