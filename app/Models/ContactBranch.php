<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactBranch extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'address',
        'phone',
        'email',
        'working_hours',
        'icon',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', true)->orderBy('sort_order')->orderBy('id');
    }
}