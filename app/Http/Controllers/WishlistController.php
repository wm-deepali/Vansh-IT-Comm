<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Models\CategoryAttribute;
use App\Services\Tracking\PixelTracker;

class WishlistController extends Controller
{

    public function index()
    {
        $ids = Wishlist::current()->latest()->pluck('product_id');

        $products = Product::query()
            ->whereIn('id', $ids)
            ->with(['brand', 'collections'])
            ->withAvg('approvedReviews', 'rating')   // same eager loads as your shop controller
            ->get()
            ->sortBy(fn($p) => $ids->search($p->id))  // keep "recently added first"
            ->values();

        // listing specs per category — reuse the exact query from your shop controller
        $catIds = $products->pluck('category_id')->merge($products->pluck('subcategory_id'))->filter()->unique();

        $listingByCategory = CategoryAttribute::with('attribute')
            ->where('show_on_listing', true)
            ->whereIn('category_id', $catIds)
            ->orderBy('sort_order')
            ->get()
            ->groupBy('category_id');

        return view('front-pages.wishlist', compact('products', 'listingByCategory'));
    }

    public function clear()
    {
        Wishlist::current()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Wishlist cleared.',
            'wishlist_count' => 0,
        ]);
    }

    public function toggle(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|integer|exists:products,id',
        ]);

        $product = Product::findOrFail($data['product_id']);

        $exists = Wishlist::current()->where('product_id', $product->id)->exists();

        if ($exists) {
            Wishlist::removeProduct($product);
            $wishlisted = false;
            $message = 'Removed from wishlist.';
        } else {
            Wishlist::addProduct($product);
            $wishlisted = true;
            $message = 'Added to wishlist.';
        }

        return response()->json([
            'status' => true,
            'message' => $message,
            'wishlisted' => $wishlisted,
            'wishlist_count' => Wishlist::current()->count(),
            'tracking_events' => $wishlisted ? PixelTracker::addToWishlist($product) : null,
        ]);
    }
}