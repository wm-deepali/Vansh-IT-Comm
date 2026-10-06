<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeBudgetCard extends Model
{
    protected $fillable = [
        'label', 'title', 'description', 'min_price', 'max_price',
        'button_text', 'gradient', 'label_color', 'button_color',
        'category_id', 'sort_order', 'is_active',
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

    /** Query string for route('shop', $card->shopParams()) */
    public function shopParams(): array
    {
        return array_filter([
            'minPrice' => $this->min_price,
            'maxPrice' => $this->max_price,
        ], fn($v) => $v !== null);
    }
}