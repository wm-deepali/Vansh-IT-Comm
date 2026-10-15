<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SeoPage;

class SeoPageSeeder extends Seeder
{
    public function run()
    {
        $pages = [
            // Public pages (key = helper ke $map me use hone wali key)
            ['key' => 'home',        'name' => 'Home'],
            ['key' => 'shop',        'name' => 'Shop Page'],
            ['key' => 'categories',  'name' => 'Categories Page'],
            ['key' => 'about',       'name' => 'About Us'],
            ['key' => 'contact',     'name' => 'Contact Us'],
            ['key' => 'blog',        'name' => 'Blog Listing Page'],
            ['key' => 'faq',         'name' => 'FAQ Page'],
            ['key' => 'repair',      'name' => 'Repair Services'],
            ['key' => 'exchange',    'name' => 'Device Exchange'],

            // Cart / checkout / customer pages
            ['key' => 'cart',        'name' => 'Cart Page'],
            ['key' => 'wishlist',    'name' => 'Wishlist Page'],
            ['key' => 'checkout',    'name' => 'Checkout Page'],
            ['key' => 'login',       'name' => 'Login Page'],
            ['key' => 'register',    'name' => 'Register Page'],
            ['key' => 'account',     'name' => 'My Account'],
            ['key' => 'track_order', 'name' => 'Track Order'],
        ];

        foreach ($pages as $p) {
            SeoPage::updateOrCreate(
                ['page_key' => $p['key']],
                ['page_name' => $p['name']]
            );
        }
    }
}