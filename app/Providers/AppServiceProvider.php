<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\AboutUs;
use App\Http\Controllers\PageController;
use App\Models\Product;
use App\Models\Slideshow;
use App\Models\Category;

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
        // Share the AboutUs data with all views
        // View::share('aboutus', AboutUs::first());

        // Share the Slideshow data with all views
        View::share('slideshow', Slideshow::where('hidden', 0)->where('cancelled', 0)->get());

        // Share the Categories with products with all views
        View::share('categories', Category::where('hidden', 0)->where('cancelled', 0)->get());
        view::share('products', Product::where('hidden', 0)->where('cancelled', 0)->get());

        // Share the Pages data with all views
        View::share('pages', PageController::getPages());
    }
}
