<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'sub_title',
        'icon',
        'meta_title',
        'meta_description',
        'image',
        'sort_order',

        'is_popular',
        'status',

        'added_by',
        'is_featured',
        'show_in_navbar',
        'is_sub_category',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')
            ->whereNull('deleted_at');
    }

    public function categoryAttributes()
    {
        return $this->hasMany(CategoryAttribute::class);
    }

    // Products directly under category
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    // Products where this category is selected as subcategory
    public function subCategoryProducts()
    {
        return $this->hasMany(Product::class, 'subcategory_id');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeParents($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeSubCategories($query)
    {
        return $query->whereNotNull('parent_id');
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    public function getIsParentAttribute()
    {
        return is_null($this->parent_id);
    }

    public function getIsChildAttribute()
    {
        return !is_null($this->parent_id);
    }

    // $category->image_url  → full URL or null
    public function getImageUrlAttribute()
    {
        if (!$this->image)
            return null;

        return str_starts_with($this->image, 'assets/')
            ? asset($this->image)
            : asset('storage/' . $this->image);
    }

    public function brands()
    {
        return $this->belongsToMany(Brand::class, 'brand_category');
    }
}