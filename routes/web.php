<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SlideshowController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\WebsiteAddressController;
use App\Models\Subcategory;
use App\Http\Controllers\WebsiteCheckoutController;
use App\Http\Controllers\WebsiteCartController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// Redirect root URL to /en
Route::get('/', function () {
    $locale = request()->getPreferredLanguage(['en', 'ar', 'ku']) ?? 'en';
    return redirect("/$locale");
});

Route::get('/login', function () {
    return view('cms/auth/login');
});

// Admin login and logout routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');

Route::middleware('auth:web')->group(function () {
    Route::get('/cms/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/cms/aboutus', [AboutUsController::class, 'edit'])->name('aboutus.edit');
    Route::put('/cms/aboutus', [AboutUsController::class, 'update'])->name('aboutus.update');
    Route::resource('/cms/users', UserController::class);
    Route::resource('/cms/brands', BrandController::class);
    Route::resource('/cms/products', ProductController::class);
    Route::resource('/cms/categories', CategoryController::class);
    Route::resource('/cms/subcategories', SubcategoryController::class);
    Route::resource('/cms/customers', CustomerController::class);
    Route::resource('/cms/orders', OrderController::class);
    Route::resource('/cms/slideshow', SlideshowController::class);
    Route::resource('/cms/permissions', PermissionController::class);
    Route::resource('tax', TaxController::class);
    Route::get('/cms/cart', [CartController::class, 'cmsindex'])->name('cart.cmsindex');

    //for drag-and-drop reorder
    Route::post('/cms/products/reorder', [ProductController::class, 'reorder'])->name('products.reorder');
    Route::post('/cms/categories/reorder', [CategoryController::class, 'reorder'])->name('categories.reorder');
    Route::post('/cms/subcategories/reorder', [SubcategoryController::class, 'reorder'])->name('subcategories.reorder');
    Route::post('/cms/slideshow/reorder', [SlideshowController::class, 'reorder'])->name('slideshow.reorder');

    //reports
    Route::get('/cms/report', [ReportController::class, 'show'])->name('report.show');
});
Route::prefix('{locale}')->middleware('localization')->group(function () {

    // Customer signin and signout and signup routes
    Route::get('/signin', [AuthController::class, 'showSignIn'])->name('customer.signin');
    Route::post('/signin', [AuthController::class, 'signIn']);
    Route::get('/signup', [AuthController::class, 'showSignUp'])->name('customer.signup');
    Route::post('/signup', [AuthController::class, 'signUp']);
    Route::post('/signout', [AuthController::class, 'signOut'])->name('customer.signout');

    Route::get('/', [WebsiteController::class, 'index'])->name('sanita.index');

    Route::get('/about', [AboutUsController::class, 'show'])->name('about');

    Route::view('/contact', 'sanita.contactus')->name('contact');

    Route::middleware('auth:customer')->group(function () {
        Route::resource('cart', WebsiteCartController::class);
        Route::resource('addresses', WebsiteAddressController::class);
        Route::get('/checkout', [WebsiteCartController::class, 'checkout'])->name('cart.checkout');
    });

    Route::get('categories', [WebsiteController::class, 'categories'])->name('website.categories.index');
    Route::get('products', [WebsiteController::class, 'products'])->name('website.products.index');
    Route::get('offers', [WebsiteController::class, 'offers'])->name('website.offers.index');


    // Password reset routes
    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
});
