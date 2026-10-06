<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = [
        'name',
        'logo',
        'status'
    ];
    
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // $brand->logo_url  → full URL or null
    public function getLogoUrlAttribute()
    {
        if (!$this->logo)
            return null;

        return str_starts_with($this->logo, 'assets/')
            ? asset($this->logo)
            : asset('storage/' . $this->logo);
    }
}