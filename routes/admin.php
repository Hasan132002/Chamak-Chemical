<?php

use App\Http\Controllers\Admin\ProductAdminController;
use App\Http\Controllers\Admin\OrderAdminController;
use App\Http\Controllers\Admin\CategoryAdminController;
use App\Http\Controllers\Admin\DealerAdminController;
use App\Http\Controllers\Admin\UserAdminController;
use Illuminate\Support\Facades\Route;

// Admin Login (No Auth Required)
Route::get('/login', function () {
    return view('admin.auth.login');
})->name('admin.login')->middleware('guest');

// Protected Admin Routes (Require Authentication)
Route::middleware('auth')->group(function () {

    // Admin Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // Products
    Route::prefix('products')->name('admin.products.')->group(function () {
        Route::get('/', [ProductAdminController::class, 'index'])->name('index');
        Route::get('/create', [ProductAdminController::class, 'create'])->name('create');
        Route::post('/', [ProductAdminController::class, 'store'])->name('store');
        Route::get('/{product}/edit', [ProductAdminController::class, 'edit'])->name('edit');
        Route::put('/{product}', [ProductAdminController::class, 'update'])->name('update');
        Route::put('/{product}/toggle-status', [ProductAdminController::class, 'toggleStatus'])->name('toggle-status');
        Route::delete('/{product}', [ProductAdminController::class, 'destroy'])->name('destroy');
    });

    // Orders
    Route::prefix('orders')->name('admin.orders.')->group(function () {
        Route::get('/', [OrderAdminController::class, 'index'])->name('index');
        Route::get('/{order}', [OrderAdminController::class, 'show'])->name('show');
        Route::put('/{order}/status', [OrderAdminController::class, 'updateStatus'])->name('updateStatus');
    });

    // Categories
    Route::prefix('categories')->name('admin.categories.')->group(function () {
        Route::get('/', [CategoryAdminController::class, 'index'])->name('index');
        Route::get('/create', [CategoryAdminController::class, 'create'])->name('create');
        Route::post('/', [CategoryAdminController::class, 'store'])->name('store');
        Route::get('/{category}/edit', [CategoryAdminController::class, 'edit'])->name('edit');
        Route::put('/{category}', [CategoryAdminController::class, 'update'])->name('update');
        Route::delete('/{category}', [CategoryAdminController::class, 'destroy'])->name('destroy');
    });

    // Dealers
    Route::prefix('dealers')->name('admin.dealers.')->group(function () {
        Route::get('/', [DealerAdminController::class, 'index'])->name('index');
        Route::get('/{dealer}', [DealerAdminController::class, 'show'])->name('show');
        Route::put('/{dealer}/approve', [DealerAdminController::class, 'approve'])->name('approve');
        Route::put('/{dealer}/reject', [DealerAdminController::class, 'reject'])->name('reject');
    });

    // Users
    Route::prefix('users')->name('admin.users.')->group(function () {
        Route::get('/', [UserAdminController::class, 'index'])->name('index');
        Route::get('/create', [UserAdminController::class, 'create'])->name('create');
        Route::post('/', [UserAdminController::class, 'store'])->name('store');
        Route::get('/{user}/edit', [UserAdminController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserAdminController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserAdminController::class, 'destroy'])->name('destroy');
    });

    // Settings
    Route::get('/settings', function () {
        return view('admin.settings');
    })->name('admin.settings');

    // Reports & Analytics
    Route::get('/reports', function () {
        return view('admin.reports.index');
    })->name('admin.reports');

    // Profile
    Route::get('/profile', function () {
        return view('admin.profile');
    })->name('admin.profile');

    // Blog Management
    Route::get('/blog', function () {
        return view('admin.blog.index');
    })->name('admin.blog.index');

    // Coupons
    Route::get('/coupons', function () {
        return view('admin.coupons.index');
    })->name('admin.coupons.index');

    // Reviews
    Route::get('/reviews', function () {
        return view('admin.reviews.index');
    })->name('admin.reviews.index');

    // Notifications
    Route::get('/notifications', function () {
        return view('admin.notifications');
    })->name('admin.notifications');

}); // End of auth middleware group
