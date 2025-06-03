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

Route::get('/login', function () {
    return view('cms/auth/login');
});
// Admin login and logout routes
Route::get('/cms/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/cms/login', [LoginController::class, 'login']);
Route::post('/cms/logout', [LoginController::class, 'logout'])->name('admin.logout');
// Customer signin and signout and signup routes
Route::get('/signin', [AuthController::class, 'showSignIn'])->name('customer.signin');
Route::post('/signin', [AuthController::class, 'signIn']);
Route::get('/signup', [AuthController::class, 'showSignUp'])->name('customer.signup');
Route::post('/signup', [AuthController::class, 'signUp']);
Route::post('/signout', [AuthController::class, 'signOut'])->name('customer.signout');

Route::get('', function () {
    return view('/sanita/index');
})->name('sanita.index');

Route::get('/about', [AboutUsController::class, 'show'])->name('about');
Route::view('/contact', 'sanita.contactus')->name('contact');

Route::middleware('auth:customer')->group(function () {
    Route::resource('cart', CartController::class)->name('index', 'cart.index');
});

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
    Route::post('/cms/permissions/ajax-update', [PermissionController::class, 'ajaxUpdate'])->name('permissions.ajaxUpdate');
});
