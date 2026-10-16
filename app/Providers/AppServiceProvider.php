<?php

namespace App\Providers;

use App\Models\Announcement;
use App\Models\Cart;
use App\Models\Category;
use App\Models\DynamicPage;
use App\Models\Setting;
use App\View\Composers\NavCategoriesComposer;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        require_once app_path('Helpers/seo.php');
    }
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // Runs for every rendered view (layout, partials, components), so load the
        // settings row once per request instead of once per view.
        View::composer('*', function ($view) {
            static $general = null;
            static $loaded = false;

            if (!$loaded) {
                $general = Setting::first();
                $loaded = true;
            }

            $view->with('general', $general);
            $view->with('googleSetting', \App\Models\GoogleSetting::first());
        });


        // Header: cart badge count + announcement bar (Announcement model, status = 1)
        View::composer('partials.header', function ($view) {
            $cart = auth('customer')->check()
                ? Cart::where('user_id', auth('customer')->id())->first()
                : Cart::where('session_id', session()->getId())->first();

            $view->with([
                'cartCount' => $cart ? (int) $cart->items()->sum('quantity') : 0,
                'announcements' => Announcement::where('status', 1)
                    ->orderBy('id')
                    ->limit(4)
                    ->get(),
            ]);
        });

        // Category mega menus (mapped attributes + static budget) for the header nav
        View::composer('partials.header', NavCategoriesComposer::class);


        View::composer('partials.footer', function ($view) {
            $view->with([
                'footerCategories' => Category::whereNull('parent_id')
                    ->where('status', 1)
                    ->orderBy('sort_order')
                    ->get(),

                // Active pages marked "Show as a tab" in admin, in tab order
                'footerPages' => DynamicPage::policies()->get(),
            ]);
        });

    }
}