<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\WishlistController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductsController::class, 'index'])->name('products.index');
Route::get('/products/{slug}', [ProductsController::class, 'show'])->name('products.show');

// Cart routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::get('/cart/data', [CartController::class, 'getCartData'])->name('cart.data');
Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

//wishlist routes
Route::middleware('auth')->group(function () {
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
Route::post('/wishlist/remove', [WishlistController::class, 'remove'])->name('wishlist.remove');
Route::post('/wishlist/clear', [WishlistController::class, 'clear'])->name('wishlist.clear');
});

Route::post('/wishlist/toggle', function (Request $request) {
    $request->validate([
        'product_id' => ['required', 'exists:products,id'],
    ]);

    $result = $request->user()
        ->wishlist()
        ->toggle($request->product_id);

    return response()->json([
        'added' => !empty($result['attached']),
    ]);
})->middleware('auth')->name('wishlist.toggle');


// Static Pages
Route::get('/contact', [PageController::class, 'contact'])->name('pages.contact');
Route::get('/about', [PageController::class, 'about'])->name('pages.about');
Route::get('/technical-support', [PageController::class, 'technicalSupport'])->name('pages.technical-support');
Route::get('/shipping-returns', [PageController::class, 'shippingReturns'])->name('pages.shipping-returns');
Route::get('/faq', [PageController::class, 'faq'])->name('pages.faq');
Route::get('/privacy', [PageController::class, 'privacy'])->name('pages.privacy');

// Contact Messages
Route::post('/contact-messages', [App\Http\Controllers\ContactMessageController::class, 'store'])->name('contact-messages.store');

// Sitemap routes
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap.index');
Route::get('/sitemap-products.xml', [SitemapController::class, 'products'])->name('sitemap.products');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
