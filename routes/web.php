<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DealerController;
use App\Http\Controllers\DealController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// Language Switcher
Route::get('/locale/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'ur'])) {
        session(['locale' => $locale]);
        app()->setLocale($locale);
    }
    return redirect()->back();
})->name('locale.switch');

// Products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');

// Categories
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');

// Cart
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

// Checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');

// Wholesale/Dealer Routes
Route::get('/wholesale', function () { return view('wholesale.info'); })->name('wholesale.info');
Route::get('/wholesale/register', [DealerController::class, 'register'])->name('wholesale.register');
Route::post('/wholesale/register', [DealerController::class, 'storeRegistration'])->name('wholesale.register.store');
Route::get('/dealer/dashboard', [DealerController::class, 'dashboard'])->name('dealer.dashboard');

// Deals
Route::get('/deals', [DealController::class, 'index'])->name('deals.index');

// Other pages

// Order Tracking
Route::get('/track-order', [AppHttpControllersOrderTrackingController::class, 'index'])->name('orders.track');
Route::post('/track-order', [AppHttpControllersOrderTrackingController::class, 'track'])->name('orders.track.search');
Route::get('/blog', function () {
    $posts = \App\Models\BlogPost::with('translations', 'author')
        ->published()
        ->latest('published_at')
        ->paginate(12);
    return view('blog.index', compact('posts'));
})->name('blog.index');
Route::get('/contact', function () { return view('contact'); })->name('contact');
Route::get('/about', function () { return view('about'); })->name('about');
Route::get('/account', function () { return view('account.dashboard'); })->name('account.dashboard')->middleware('auth');
Route::post('/newsletter/subscribe', function () { return back()->with('success', 'Subscribed!'); })->name('newsletter.subscribe');

// Policy Pages
Route::get('/privacy-policy', function () { return view('pages.privacy-policy'); })->name('privacy-policy');
Route::get('/terms-of-service', function () { return view('pages.terms-of-service'); })->name('terms-of-service');
Route::get('/refund-policy', function () { return view('pages.refund-policy'); })->name('refund-policy');

// Breeze Authentication Routes
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Admin Routes with /admin prefix
Route::prefix('admin')->group(function () {
    require __DIR__.'/admin.php';
});
