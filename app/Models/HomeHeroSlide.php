<?php

namespace App\Models;

use App\Models\Concerns\ResolvesLinks;
use Illuminate\Database\Eloquent\Model;

class HomeHeroSlide extends Model
{
    use ResolvesLinks;

    protected $fillable = [
        'badge_text', 'badge_icon', 'theme',
        'title_line_1', 'title_highlight', 'description',
        'btn_primary_text', 'btn_primary_icon', 'btn_primary_route', 'btn_primary_url',
        'btn_secondary_text', 'btn_secondary_icon', 'btn_secondary_route', 'btn_secondary_url',
        'link_text', 'link_route', 'link_url',
        'trust_points',
        'card_image', 'card_image_alt', 'card_top_badge', 'card_bottom_badge',
        'card_label', 'card_title', 'card_subtitle', 'card_old_price', 'card_price',
        'sort_order', 'is_active',
    ];

    protected $casts = [
        'trust_points' => 'array',
        'is_active'    => 'boolean',
    ];

    public function scopeActive($q)
    {
        return $q->where('is_active', true);
    }

    public function scopeOrdered($q)
    {
        return $q->orderBy('sort_order')->orderBy('id');
    }

    public function getCardImageUrlAttribute(): ?string
    {
        return $this->card_image ? asset($this->card_image) : null;
    }
}