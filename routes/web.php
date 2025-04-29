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

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/', function () {
    return view('/sanita/index');
})->name('index');

Route::middleware(['auth'])->group(function () {

    Route::get('/cms/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/cms/aboutus', [AboutUsController::class, 'edit'])->name('aboutus.edit');
    Route::put('/cms/aboutus', [AboutUsController::class, 'update'])->name('aboutus.update');

    Route::get('/cms/users', [UserController::class, 'index'])->name('users.index'); // View and create users
    Route::post('/cms/users', [UserController::class, 'store'])->name('users.store'); // Store new user
    Route::get('/cms/users/create', [UserController::class, 'create'])->name('users.create'); // Create user form
    Route::get('/cms/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit'); // Edit user form
    Route::put('/cms/users/{user}', [UserController::class, 'update'])->name('users.update'); // Update user
    Route::delete('/cms/users/{user}', [UserController::class, 'destroy'])->name('users.destroy'); // Delete user

    Route::get('/cms/brands', [BrandController::class, 'index'])->name('brands.index'); // View all brands
    Route::post('/cms/brands', [BrandController::class, 'store'])->name('brands.store'); // Store new brand
    Route::get('/cms/brands/create', [BrandController::class, 'create'])->name('brands.create'); // Create brand form
    Route::get('/cms/brands/{brand}/edit', [BrandController::class, 'edit'])->name('brands.edit'); // Edit brand form
    Route::put('/cms/brands/{brand}', [BrandController::class, 'update'])->name('brands.update'); // Update brand
    Route::delete('/cms/brands/{brand}', [BrandController::class, 'destroy'])->name('brands.destroy'); // Delete brand

    Route::resource('/cms/products', ProductController::class);
    Route::resource('/cms/categories', CategoryController::class);
    Route::resource('/cms/subcategories', SubcategoryController::class);
    Route::resource('/cms/customers', CustomerController::class);
    Route::resource('/cms/orders', OrderController::class);
    
});
