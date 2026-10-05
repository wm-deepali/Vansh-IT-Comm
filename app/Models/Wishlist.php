<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $fillable = [
        'customer_id',
        'session_id',
        'product_id',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    /** Per-request cache of the current visitor's wishlisted product ids */
    protected static ?array $idsCache = null;

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeCurrent($query)
    {
        if (auth('customer')->check()) {
            return $query->where('customer_id', auth('customer')->id());
        }

        return $query->where('session_id', session()->getId())
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
            });
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public static function currentProductIds(): array
    {
        return static::$idsCache ??= static::current()->pluck('product_id')->all();
    }

    public static function addProduct(Product $product)
    {
        $isCustomer = auth('customer')->check();

        static::$idsCache = null;

        return static::firstOrCreate(
            [
                'customer_id' => $isCustomer ? auth('customer')->id() : null,
                'session_id'  => $isCustomer ? null : session()->getId(),
                'product_id'  => $product->id,
            ],
            [
                'expires_at'  => $isCustomer ? null : now()->addDays(30),
            ]
        );
    }

    public static function removeProduct(Product $product)
    {
        static::$idsCache = null;

        return static::current()
            ->where('product_id', $product->id)
            ->delete();
    }
}