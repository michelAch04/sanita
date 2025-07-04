<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\AuthController;

use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\WebsiteAddressController;
use App\Http\Controllers\WebsiteCartController;
use App\Http\Controllers\WebsiteOrderController;

use App\Http\Controllers\CMS\DistributorController;
use App\Http\Controllers\CMS\ProductController;
use App\Http\Controllers\CMS\TaxController;
use App\Http\Controllers\CMS\SlideshowController;
use App\Http\Controllers\CMS\PermissionController;
use App\Http\Controllers\CMS\DashboardController;
use App\Http\Controllers\CMS\AboutUsController;
use App\Http\Controllers\CMS\UserController;
use App\Http\Controllers\CMS\BrandController;
use App\Http\Controllers\CMS\CategoryController;
use App\Http\Controllers\CMS\ReportController;
use App\Http\Controllers\CMS\SubcategoryController;
use App\Http\Controllers\CMS\CustomerController;
use App\Http\Controllers\CMS\OrderController;
use App\Http\Controllers\CMS\CartController;





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
    //dashboard
    Route::get('/cms/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    //about us 
    Route::get('/cms/aboutus', [AboutUsController::class, 'edit'])->name('aboutus.edit');
    Route::put('/cms/aboutus', [AboutUsController::class, 'update'])->name('aboutus.update');
    // CMS routes
    Route::resource('/cms/users', UserController::class);
    Route::resource('/cms/brands', BrandController::class);
    Route::resource('/cms/products', ProductController::class);
    Route::resource('/cms/categories', CategoryController::class);
    Route::resource('/cms/subcategories', SubcategoryController::class);
    Route::resource('/cms/customers', CustomerController::class);
    Route::resource('/cms/orders', OrderController::class);
    Route::resource('/cms/slideshow', SlideshowController::class);
    Route::resource('/cms/permissions', PermissionController::class);
    Route::resource('/cms/tax', TaxController::class);
    Route::resource('/cms/cart', CartController::class);
    //distributor
    Route::resource('/cms/distributor', DistributorController::class);
    Route::get('cms/distributor/{distributor}/add-address', [DistributorController::class, 'addAddress'])->name('distributor.addAddress');
    Route::post('cms/distributor/{distributor}/store-address', [DistributorController::class, 'storeAddress'])->name('distributor.storeAddress');
    Route::delete('cms/distributor/{distributor}/address/{address}', [DistributorController::class, 'removeAddress'])->name('distributor.removeAddress');
    Route::get('cms/distributor/{id}/stocks', [DistributorController::class, 'stocks'])->name('distributor.stocks');
    Route::post('cms/distributor/{id}/stocks', [DistributorController::class, 'storeStock'])->name('distributor.storeStock');
    Route::delete('cms/distributor/{distributor}/remove-stock/{product}', [DistributorController::class, 'removeStock'])->name('distributor.removeStock');
    //for drag-and-drop reorder
    Route::post('/cms/products/reorder', [ProductController::class, 'reorder'])->name('products.reorder');
    Route::post('/cms/categories/reorder', [CategoryController::class, 'reorder'])->name('categories.reorder');
    Route::post('/cms/subcategories/reorder', [SubcategoryController::class, 'reorder'])->name('subcategories.reorder');
    Route::post('/cms/slideshow/reorder', [SlideshowController::class, 'reorder'])->name('slideshow.reorder');
    //reports
    Route::get('/cms/report', [ReportController::class, 'show'])->name('report.show');
});
Route::prefix('{locale}')->middleware(['localization', 'force.address.modal'])->group(function () {
    // Authentication routes
    Route::get('/signin', [AuthController::class, 'showSignIn'])->name('customer.signin');
    Route::post('/signin', [AuthController::class, 'signIn']);
    // signup routes
    Route::get('/signup', [AuthController::class, 'showSignUp'])->name('customer.signup');
    Route::post('/signup', [AuthController::class, 'signUp']);
    // OTP verification routes
    Route::get('/verifyotp', [AuthController::class, 'showVerifyOtp'])->name('customer.verifyotp');
    Route::post('/verifyotp', [AuthController::class, 'verifyOtp'])->name('customer.verifyOtp');
    Route::get('/resend-otp', [AuthController::class, 'resendOtp'])->name('customer.resendOtp');
    // Sign out route
    Route::post('/signout', [AuthController::class, 'signOut'])->name('customer.signout');

    Route::get('/', [WebsiteController::class, 'index'])->name('sanita.index');

    Route::get('/about', [AboutUsController::class, 'show'])->name('about');

    Route::view('/contact', 'sanita.contactus')->name('contact');

    Route::middleware('auth:customer')->group(function () {
        Route::resource('cart', WebsiteCartController::class)->names([
            'index' => 'website.cart.index',
            'create' => 'website.cart.create',
            'store' => 'website.cart.store',
            'show' => 'website.cart.show',
            'edit' => 'website.cart.edit',
            'update' => 'website.cart.update',
            'destroy' => 'website.cart.destroy',
        ]);

        Route::post('/checkout/place-order', [WebsiteOrderController::class, 'placeOrder'])->name('website.checkout.place_order');
        Route::get('/orders', [WebsiteOrderController::class, 'index'])->name('website.orders.index');
        Route::get('/orders/{id}/show', [WebsiteOrderController::class, 'show'])->name('website.orders.show');
        Route::get('/orders/{id}/reorder', [WebsiteOrderController::class, 'reorder'])->name('website.orders.reorder');

        Route::resource('addresses', WebsiteAddressController::class);
        //address routes
        Route::post('/addresses/{address}/set-default', [WebsiteAddressController::class, 'setDefault'])->name('addresses.setDefault');
        Route::get('/get-districts', [WebsiteAddressController::class, 'getDistricts']);
        Route::get('/get-cities', [WebsiteAddressController::class, 'getCities']);

        Route::get('/checkout', [WebsiteCartController::class, 'checkout'])->name('cart.checkout');
    });

    Route::get('categories', [WebsiteController::class, 'categories'])->name('website.categories.index');
    Route::get('products', [WebsiteController::class, 'products'])->name('website.products.index');
    Route::get('offers', [WebsiteController::class, 'offers'])->name('website.offers.index');
    Route::get('category', [WebsiteController::class, 'category'])->name('website.category.index');
    Route::get('/product', [WebsiteController::class, 'product'])->name('website.product.index');


    // Password reset routes
    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
});
