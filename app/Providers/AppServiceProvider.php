<?php

namespace App\Providers;
use App\Models\Cart;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            $general = \App\Models\Setting::first();

            $view->with(
                [
                    'general' => $general,
                ]
            );
        });


        View::composer('partials.header', function ($view) {
            $cart = auth('customer')->check()
                ? Cart::where('user_id', auth('customer')->id())->first()
                : Cart::where('session_id', session()->getId())->first();

            $view->with('cartCount', $cart ? (int) $cart->items()->sum('quantity') : 0);
        });


    }
}
