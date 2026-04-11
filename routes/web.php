<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ==================== CLIENT ROUTES (không cần đăng nhập) ====================
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

// ==================== ROUTES YÊU CẦU ĐĂNG NHẬP (customer & admin đều dùng) ====================
Route::middleware(['auth'])->group(function () {
    // Đơn hàng của tôi
    Route::get('/my-orders', function () {
        $orders = auth()->user()->orders()->with('items.product')->get();
        return view('client.orders', compact('orders'));
    })->name('client.orders');

    // Thông tin cá nhân
    Route::get('/profile', [ProfileController::class, 'showForm'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Đổi mật khẩu
    Route::get('/change-password', [ChangePasswordController::class, 'showForm'])->name('change.password.form');
    Route::post('/change-password', [ChangePasswordController::class, 'update'])->name('change.password.update');
});

// ==================== ADMIN ROUTES (yêu cầu role admin) ====================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard admin
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Quản lý đơn hàng
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}/edit', [OrderController::class, 'edit'])->name('orders.edit');
    Route::put('/orders/{id}', [OrderController::class, 'update'])->name('orders.update');

    // Quản lý sản phẩm (CRUD)
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
});

// ==================== AUTH ROUTES (Breeze) ====================
require __DIR__.'/auth.php';