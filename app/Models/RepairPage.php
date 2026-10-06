<?php
// app/Models/RepairPage.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RepairPage extends Model
{
    protected $fillable = [
        'meta_title', 'meta_description',
        'hero_badge', 'hero_title', 'hero_description', 'hero_primary_text', 'hero_secondary_text',
        'booking_badge', 'booking_title', 'booking_description', 'booking_note',
    ];
}