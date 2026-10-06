<?php

namespace App\Models;

use App\Models\Concerns\ResolvesLinks;
use Illuminate\Database\Eloquent\Model;

class HomeCtaBlock extends Model
{
    use ResolvesLinks;

    protected $fillable = [
        'key', 'badge_text', 'title', 'description',
        'btn_1_text', 'btn_1_icon', 'btn_1_route', 'btn_1_url',
        'btn_2_text', 'btn_2_icon', 'btn_2_route', 'btn_2_url',
        'btn_3_text', 'btn_3_icon', 'btn_3_route', 'btn_3_url',
        'items', 'is_active',
    ];

    protected $casts = [
        'items'     => 'array',
        'is_active' => 'boolean',
    ];

    /** All blocks keyed by key: $blocks['repair_cta']->title */
    public static function allKeyed()
    {
        return static::all()->keyBy('key');
    }
}