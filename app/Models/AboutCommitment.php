<?php
// app/Models/AboutCommitment.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutCommitment extends Model
{
    protected $fillable = ['icon', 'color', 'title', 'description', 'sort_order', 'status'];

    protected $casts = ['status' => 'boolean'];

    public function scopeActive($query)
    {
        return $query->where('status', true)->orderBy('sort_order')->orderBy('id');
    }
}