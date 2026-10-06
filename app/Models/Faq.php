<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    // key (saved in DB) => label (shown on the site)
    public const CATEGORIES = [
        'Warranty' => 'Warranty & Claims',
        'Testing'  => '20-Point QC Testing',
        'Shipping' => 'Shipping & Returns',
        'Payments' => 'GST Billing & Payments',
    ];

    protected $fillable = [
        'question',
        'answer',
        'category',
        'sort_order',
        'show_home',
        'status'
    ];

    protected $casts = [
        'show_home' => 'boolean',
        'status'    => 'boolean',
    ];
}