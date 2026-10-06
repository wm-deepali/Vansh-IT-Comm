<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExchangePage extends Model
{
    protected $guarded = [];

    // Single-row table: always returns the one record (creates it if missing)
    public static function content(): self
    {
        return static::first() ?? static::create([]);
    }
}