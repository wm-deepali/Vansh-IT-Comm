<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExchangeBrandRule extends Model
{
    protected $guarded = [];
    protected $casts = ['status' => 'boolean'];

    public function scopeActive($q)
    {
        return $q->where('status', 1)->orderBy('sort_order')->orderBy('id');
    }
}