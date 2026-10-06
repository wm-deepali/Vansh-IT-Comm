<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DynamicPage extends Model
{
    protected $fillable = [
        'page_name',
        'heading',
        'content',
        'meta_title',
        'meta_description',
        'status',
        'show_in_policies',
        'sort_order',
        'icon',
        'badge',
        'summary',
    ];

    protected $casts = [
        'show_in_policies' => 'boolean',
    ];

    // Active pages only
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Pages shown as tabs on the Terms & Policies page, in admin order
    public function scopePolicies($query)
    {
        return $query->active()
            ->where('show_in_policies', true)
            ->orderBy('sort_order')
            ->orderBy('id');
    }
}