<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\OrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::post('/search-suggestions', [ProductController::class, 'suggestions'])->name('search.suggestions');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');

Route::view('/contact', 'client.contact')->name('contact');
Route::view('/about', 'client.about')->name('about');

Route::middleware(['auth'])->group(function () {
    Route::get('/my-orders', function () {
        $orders = auth()->user()->orders()->with('items.product')->get();
        return view('client.orders', compact('orders'));
    })->name('client.orders');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}/edit', [OrderController::class, 'edit'])->name('orders.edit');
    Route::put('/orders/{id}', [OrderController::class, 'update'])->name('orders.update');
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
});

Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->name('dashboard');

require __DIR__.'/auth.php';