<?php
// app/Models/RepairService.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RepairService extends Model
{
    public const COLORS = ['blue', 'emerald', 'purple', 'amber', 'rose', 'indigo', 'sky', 'slate'];

    protected $fillable = [
        'repair_category_id', 'title', 'description', 'estimated_time',
        'icon', 'color', 'sort_order', 'status',
    ];

    protected $casts = ['status' => 'boolean'];

    public function category()
    {
        return $this->belongsTo(RepairCategory::class, 'repair_category_id');
    }
}