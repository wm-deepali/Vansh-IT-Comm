<?php
// app/Models/AboutTestItem.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutTestItem extends Model
{
    protected $fillable = ['about_test_group_id', 'title', 'sort_order'];

    public function group()
    {
        return $this->belongsTo(AboutTestGroup::class, 'about_test_group_id');
    }
}