<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\CMS\PageController;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;

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
        // Force HTTPS for all generated URLs when the request is secure or in production
        if (request()->isSecure() || $this->app->environment('production')) {
            URL::forceScheme('https');
        }

        Paginator::useBootstrapFive(); // or Paginator::useBootstrapFour();

        View::composer('*', function ($view) {
            $isRtl = app()->getLocale() === 'ar' || app()->getLocale() === 'ku';
            $view->with('isRtl', $isRtl);
            
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
