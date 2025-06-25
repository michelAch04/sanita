<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\AboutUs;
use App\Http\Controllers\PageController;
use App\Models\Product;
use App\Models\Slideshow;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use Illuminate\Pagination\Paginator;

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
        Paginator::useBootstrapFive(); // or Paginator::useBootstrapFour();
        View::composer('*', function ($view) {
            $customerId = auth()->guard('customer')->id(); // Use the correct guard

            $cart = Cart::with('cartDetails')
                ->where('customers_id', $customerId)
                ->first();

            $cartCount = $cart ? $cart->cartDetails->count() : 0;
            $view->with('cartCount', $cartCount);

            $userId = Auth::guard('web')->id();
            $permissions = $userId ? PageController::getPages($userId) : collect();
            $view->with('permissions', $permissions);
        });
    }
}
