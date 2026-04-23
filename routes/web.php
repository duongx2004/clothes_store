<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::post('/search-suggestions', [ProductController::class, 'suggestions'])->name('search.suggestions');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');

Route::view('/contact', 'client.contact')->name('contact');
Route::view('/about', 'client.about')->name('about');

Route::get('/thanks', function () {
    return view('client.thanks');
})->name('thanks');
Route::get('/vnpay-return', [PaymentController::class, 'vnpayReturn'])->name('vnpay.return');

Route::middleware(['auth'])->group(function () {
    Route::get('/my-orders', function () {
        $orders = auth()->user()->orders()->with('items.product')->get();
        return view('client.orders', compact('orders'));
    })->name('client.orders');
    Route::get('/profile', [ProfileController::class, 'showForm'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/change-password', [ChangePasswordController::class, 'showForm'])->name('change.password.form');
    Route::post('/change-password', [ChangePasswordController::class, 'update'])->name('change.password.update');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class);
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::get('/revenue', [\App\Http\Controllers\Admin\RevenueController::class, 'index'])->name('revenue.index');
    Route::resource('brands', \App\Http\Controllers\Admin\BrandController::class);
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
});

require __DIR__.'/auth.php';