<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'tags',
        'read_time',
        'image',
        'short_description',
        'content',
        'author_name',
        'author_role',
        'author_image',
        'meta_title',
        'meta_description',
        'show_home',
        'status'
    ];

    protected $casts = [
        'tags'      => 'array',
        'show_home' => 'boolean',
        'status'    => 'boolean',
    ];

    // Featured image URL (placeholder when none)
    public function getImageUrlAttribute()
    {
        return $this->image
            ? asset('storage/' . $this->image)
            : asset('assets/img/placeholder.jpg');
    }

    // Author photo URL (default avatar when none)
    public function getAuthorImageUrlAttribute()
    {
        return $this->author_image
            ? asset('storage/' . $this->author_image)
            : asset('assets/img/product-1588872657578-7efd1f1555ed.jpg');
    }

    public function getAuthorNameDisplayAttribute()
    {
        return $this->author_name ?: 'Vansh Sharma';
    }

    public function getAuthorRoleDisplayAttribute()
    {
        return $this->author_role ?: 'Hardware Diagnostic Lead';
    }

    // Manual read time if set, otherwise calculated from content
    public function getReadTimeMinutesAttribute()
    {
        return $this->read_time ?: max(1, (int) ceil(str_word_count(strip_tags($this->content)) / 200));
    }

    // First tag, used as the badge on cards
    public function getFirstTagAttribute()
    {
        return $this->tags[0] ?? 'Tech Guide';
    }
}