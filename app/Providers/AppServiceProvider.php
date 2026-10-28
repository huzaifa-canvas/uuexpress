<?php

namespace App\Providers;

use App\Models\Service;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
    public function boot(): void
    {
        // Admin panel uses Bootstrap 5, so render pagination to match.
        Paginator::useBootstrapFive();

        // Share service prices + cart count with the public layout so the
        // booking modal can price services and the header shows the cart badge.
        View::composer('layouts.public', function ($view) {
            $view->with('servicePrices', Service::where('is_active', true)->pluck('price', 'name'));
            $view->with('cartCount', app(\App\Support\Cart::class)->count());
        });
    }
}
