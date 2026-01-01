<?php

use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ToppingController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

// Admin Authentication
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Protected Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Products
    Route::resource('products', ProductController::class);
    Route::delete('/products/images/{id}', [ProductController::class, 'deleteImage'])->name('products.images.delete');

    // Categories
    Route::resource('categories', CategoryController::class);

    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.status');
    Route::post('/orders/{id}/payment', [OrderController::class, 'updatePayment'])->name('orders.payment');
    Route::get('/orders/{id}/print', [OrderController::class, 'print'])->name('orders.print');
    Route::get('/orders-export', [OrderController::class, 'export'])->name('orders.export');

    // Users
    Route::resource('users', UserController::class);
    Route::post('/users/{id}/update-role', [UserController::class, 'updateRole'])->name('users.updateRole');

    // Comments
    Route::get('/comments', [CommentController::class, 'index'])->name('comments.index');
    Route::post('/comments/{id}/status', [CommentController::class, 'updateStatus'])->name('comments.status');
    Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::post('/comments/bulk', [CommentController::class, 'bulkAction'])->name('comments.bulk');

    // News
    Route::resource('news', NewsController::class);

    // Toppings
    Route::resource('toppings', ToppingController::class);

    // About
    Route::resource('about', AboutController::class);

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings/general', [SettingController::class, 'updateGeneral'])->name('settings.general');
    Route::post('/settings/logo', [SettingController::class, 'updateLogo'])->name('settings.logo');
    Route::post('/settings/social', [SettingController::class, 'updateSocial'])->name('settings.social');
    Route::post('/settings/payment', [SettingController::class, 'updatePayment'])->name('settings.payment');
    Route::post('/settings/bank', [SettingController::class, 'updateBank'])->name('settings.bank');
    Route::post('/settings/shipping', [SettingController::class, 'updateShipping'])->name('settings.shipping');
});
