<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WatchlistController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return redirect()->route('home');
})->name('root');

Route::middleware(['guestOrVerified'])->group(function () {
    Route::get('/home',  [OrganizationController::class, 'index'])->name('home');
    Route::get('/about', [OrganizationController::class, 'about'])->name('about.index');
    Route::get('/contact', [OrganizationController::class, 'contact'])->name('contact.index');
    Route::post('/contact', [OrganizationController::class, 'storeContact'])->name('contact.store');
    Route::get('/privacy-policy', [OrganizationController::class, 'privacyPolicy'])->name('law.privacy-policy');
    Route::get('/terms-conditions', [OrganizationController::class, 'termsConditions'])->name('law.terms-conditions');

    Route::get('/product', [ProductController::class, 'index'])->name('product.index');
    Route::get('/product/{product:slug}', [ProductController::class, 'show'])->name('product.view');

    Route::prefix('/cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::get('/{product:slug}', [CartController::class, 'show'])->name('view');
        Route::post('/add/{product:slug}', [CartController::class, 'add'])->name('add');
        Route::post('/remove/{product:slug}', [CartController::class, 'remove'])->name('remove');
        Route::post('/update-quantity/{product:slug}', [CartController::class, 'updateQuantity'])->name('update-quantity');
    });

    Route::prefix('/watchlist')->name('watchlist.')->group(function () {
        Route::get('/', [WatchlistController::class, 'index'])->name('index');
        Route::get('/{product:slug}', [WatchlistController::class, 'show'])->name('view');
        Route::post('/add/{product:slug}', [WatchlistController::class, 'add'])->name('add');
        Route::post('/remove/{product:slug}', [WatchlistController::class, 'remove'])->name('remove');
        Route::post('/status', [WatchlistController::class, 'status'])->name('status');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.view');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/proceed', [CheckoutController::class, 'confirm'])->name('checkout.confirm');
    Route::post('/checkout/proceed', [CheckoutController::class, 'checkout'])->name('checkout.confirmed');
    Route::post('/checkout/proceed/{order}', [CheckoutController::class, 'checkoutOrder'])->name('checkout.confirmed-with-order');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/failure', [CheckoutController::class, 'failure'])->name('checkout.failure');

    Route::middleware('customer')->group(function () {
        Route::get('/order', [OrderController::class, 'index'])->name('order.index');
        Route::get('/order/{order}', [OrderController::class, 'show'])->name('order.view');
        Route::patch('/order/{order}', [OrderController::class, 'update'])->name('order.update');
        Route::get('/order/invoice/{order}', [OrderController::class, 'invoice'])->name('order.invoice');
    });
});

require __DIR__.'/auth.php';
