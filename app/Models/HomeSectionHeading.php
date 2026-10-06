<?php

namespace App\Models;

use App\Models\Concerns\ResolvesLinks;
use Illuminate\Database\Eloquent\Model;

class HomeSectionHeading extends Model
{
    use ResolvesLinks;

    protected $fillable = [
        'key', 'eyebrow', 'title', 'subtitle',
        'link_text', 'link_route', 'link_url', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /** Fetch every heading once, keyed by section key: $headings['brands']->title */
    public static function allKeyed()
    {
        return static::all()->keyBy('key');
    }
}