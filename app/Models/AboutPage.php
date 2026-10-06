<?php
// app/Models/AboutPage.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutPage extends Model
{
    protected $fillable = [
        'hero_badge', 'hero_title', 'hero_description',
        'who_badge', 'who_title', 'who_description', 'who_image',
        'testing_badge', 'testing_title', 'testing_description',
        'banner_title', 'banner_text', 'banner_button_text', 'banner_button_url',
    ];

    // Works for files in /public (img/...) and for uploads on the public disk
    public function getWhoImageUrlAttribute(): ?string
    {
        if (!$this->who_image) {
            return null;
        }

        return file_exists(public_path($this->who_image))
            ? asset($this->who_image)
            : asset('storage/' . $this->who_image);
    }

    public function getWhoParagraphsAttribute(): array
    {
        return $this->who_description
            ? array_values(array_filter(preg_split('/\R{2,}/', trim($this->who_description))))
            : [];
    }
}