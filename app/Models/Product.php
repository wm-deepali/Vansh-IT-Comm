<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [

        'category_id',
        'subcategory_id',
        'brand_id',

        'name',
        'slug',

        'sku',

        'short_description',
        'description',

        // electronics fields
        'condition',
        'warranty',
        'condition_details',
        'warranty_coverage',
        'shipping_delivery',
        'key_specs',

        'warranty_backed',
        'seven_day_returns',
        'insured_transit',
        'video_call_demo',

        'mrp',
        'discount_type',
        'discount',
        'price',

        'stock',
        'min_qty',

        'delivery_time',

        'quality',
        'pan_india',

        'meta_title',
        'meta_description',

        'status',

    ];

    protected $casts = [

        'status' => 'boolean',
        'quality' => 'boolean',
        'pan_india' => 'boolean',

        'warranty_backed' => 'boolean',
        'seven_day_returns' => 'boolean',
        'insured_transit' => 'boolean',
        'video_call_demo' => 'boolean',

        'key_specs' => 'array',

    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Category::class, 'subcategory_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * ✅ Used across all grid/listing views (homepage sections, product
     * listing pages, luxury tabs, etc). Prefers the compressed THUMB
     * (400px) since these are always shown small — falls back to the
     * full image for older rows created before the thumb column existed.
     */
    public function getDisplayImageAttribute()
    {
        $default = $this->images()
            ->where('is_default', 1)
            ->first();

        if ($default) {
            return asset('storage/' . ($default->thumb ?? $default->image));
        }

        $image = $this->images()->first();

        return $image
            ? asset('storage/' . ($image->thumb ?? $image->image))
            : null;
    }

    /**
     * Attribute values grouped by attribute name, e.g.
     * ['RAM' => '16 GB', 'Operating System' => 'Windows 11'].
     * Needs attributeValues.attribute + attributeValues.value (eager load them).
     */
    public function attributeSummary(): array
    {
        return $this->attributeValues
            ->filter(fn ($av) => $av->attribute && $av->value)
            ->groupBy(fn ($av) => $av->attribute->name)
            ->map(fn ($group) => $group->map(fn ($av) => $av->value->value)->implode(', '))
            ->all();
    }

    /** Value of one attribute by name, or null. */
    public function attr(string $name): ?string
    {
        return $this->attributeSummary()[$name] ?? null;
    }

    /** Value of one Key Specification row by label (case-insensitive), or null. */
    public function keySpec(string $label): ?string
    {
        foreach ($this->key_specs ?? [] as $spec) {
            if (strcasecmp($spec['label'] ?? '', $label) === 0) {
                return $spec['value'] ?? null;
            }
        }

        return null;
    }

    public function attributeValues()
    {
        return $this->hasMany(ProductAttributeValue::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    // product videos (Media → Video)
    public function videos()
    {
        return $this->hasMany(ProductVideo::class);
    }

    // addon options (Addon Options section)
    public function addons()
    {
        return $this->hasMany(ProductAddon::class);
    }

    public function collections()
    {
        return $this->belongsToMany(
            Collection::class,
            'collection_product',
            'product_id',
            'collection_id'
        );
    }

    public function cartItems()
    {
        return $this->hasMany(
            CartItem::class
        );
    }

    public function scopeVisible($query)
    {
        $query->where('status', 1);

        if (StockSetting::current()->auto_disable_out_of_stock) {
            $query->where('stock', '>', 0);
        }

        return $query;
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function approvedReviews()
    {
        return $this->hasMany(ProductReview::class)->where('status', 'approved');
    }

    public const CONDITIONS = ['New', 'Refurbished', 'Open Box'];

    
}