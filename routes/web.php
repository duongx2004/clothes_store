```php
<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::post('/search-suggestions', [ProductController::class, 'suggestions'])->name('search.suggestions');

// 🛒 CART
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
<<<<<<< HEAD
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/checkout', [CartController::class, 'showCheckout'])->name('checkout.show');
Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');
=======

Route::middleware(['auth'])->group(function () {
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

    // 🔥 CHECKOUT CHUẨN (đã fix)
    Route::post('/checkout', [PaymentController::class, 'checkout'])->name('checkout');
});
>>>>>>> b5ca822 (cart vnpay)

// 📄 Trang tĩnh
Route::view('/contact', 'client.contact')->name('contact');
Route::view('/about', 'client.about')->name('about');

// ✅ Trang thành công
Route::get('/thanks', function () {
    return view('client.thanks');
})->name('thanks');

// 🔥 VNPay return (GIỮ NGUYÊN)
Route::get('/vnpay-return', [PaymentController::class, 'vnpayReturn'])->name('vnpay.return');

// 👤 User
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

require __DIR__.'/auth.php';
