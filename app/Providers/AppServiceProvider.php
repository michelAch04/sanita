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
        View::composer('*', function ($view) {
            $userId = Auth::guard('web')->id();
            $permissions = $userId ? PageController::getPages($userId) : collect();
            $view->with('permissions', $permissions);
        });
    }
}
