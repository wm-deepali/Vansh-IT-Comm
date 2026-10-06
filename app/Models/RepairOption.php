<?php
// app/Models/RepairOption.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RepairOption extends Model
{
    public const TYPES = [
        'device_type'  => 'Device Types',
        'issue'        => 'Problems / Issues',
        'service_mode' => 'Service Modes',
    ];

    protected $fillable = ['type', 'label', 'value', 'sort_order', 'status'];

    protected $casts = ['status' => 'boolean'];
}