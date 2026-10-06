<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeFeature extends Model
{
    public const SECTION_TRUST = 'trust_strip';
    public const SECTION_WHY   = 'why_us';

    protected $fillable = [
        'section', 'icon', 'color', 'title', 'subtitle', 'sort_order', 'is_active',
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

    public function scopeSection($q, string $section)
    {
        return $q->where('section', $section);
    }
}