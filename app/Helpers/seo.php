<?php

use App\Models\DynamicPage;
use App\Models\SeoPage;
use App\Models\Blog;
use App\Models\Product;
use App\Models\Category;

function getSeo()
{
    $route = optional(request()->route())->getName();

    switch ($route) {

        // /category/{slug}
        case 'category.show':
            return Category::where('slug', request()->route('slug'))->first();

        // /product/{slug}
        case 'product.show':
            return Product::where('slug', request()->route('slug'))->first();

        // /blog/{slug}
        case 'blog.detail':
            return Blog::where('slug', request()->route('slug'))->first();

        // /policies?tab=<page_name>  (controller isi tarah tab choose karta hai)
        case 'policies':
            $tab = request()->query('tab');

            if ($tab) {
                $page = DynamicPage::policies()->where('page_name', $tab)->first();
                if ($page) {
                    return $page;
                }
            }

            return SeoPage::where('page_key', 'policies')->first();

        default:
            // route name => seo_pages.page_key
            $map = [
                'home'             => 'home',
                'shop'             => 'shop',
                'categories'       => 'categories',
                'about'            => 'about',
                'contact'          => 'contact',
                'blog'             => 'blog',
                'faq'              => 'faq',
                'repair'           => 'repair',
                'exchange'         => 'exchange',
                'cart'             => 'cart',
                'wishlist'         => 'wishlist',
                'checkout'         => 'checkout',
                'user.login'       => 'login',
                'user.register'    => 'register',
                'user.account'     => 'account',
                'user.track-order' => 'track_order',
            ];

            // Unmapped route (order.success, cart.add, etc.) → koi SEO record nahi
            if (!isset($map[$route])) {
                return null;
            }

            return SeoPage::where('page_key', $map[$route])->first();
    }
}