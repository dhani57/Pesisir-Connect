<?php

use App\Http\Controllers\Vendor\VendorDashboardController;
use App\Http\Controllers\Vendor\VendorProductController;
use App\Http\Controllers\Vendor\VendorOrderController;
use App\Http\Controllers\Vendor\VendorSettingsController;
use App\Http\Controllers\Vendor\VendorAnalyticsController;
use App\Http\Controllers\Vendor\VendorReviewController;
use App\Http\Controllers\Vendor\VendorEarningsController;
use App\Http\Controllers\Vendor\VendorChatController;
use App\Http\Controllers\Vendor\VendorNotificationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Vendor Routes
|--------------------------------------------------------------------------
| These routes are loaded by RouteServiceProvider and assigned to the
| "web" middleware group plus "auth" and "vendor" middleware.
*/

Route::middleware(['auth', 'vendor'])->prefix('vendor')->name('vendor.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [VendorDashboardController::class, 'index'])->name('dashboard');

    // Products (Resource CRUD except show)
    Route::resource('products', VendorProductController::class)->except(['show']);
    Route::patch('products/{product}/toggle-status', [VendorProductController::class, 'toggleStatus'])->name('products.toggle-status');

    // Orders
    Route::get('orders', [VendorOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{transaction}', [VendorOrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{transaction}/status', [VendorOrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::post('orders/{transaction}/send-invoice', [VendorOrderController::class, 'sendInvoice'])->name('orders.send-invoice');
    Route::get('orders/{transaction}/invoice-pdf', [VendorOrderController::class, 'downloadInvoice'])->name('orders.invoice-pdf');
    Route::post('orders/{transaction}/notes', [VendorOrderController::class, 'addNotes'])->name('orders.add-notes');

    // Profile & Settings
    Route::get('profile', [VendorSettingsController::class, 'profile'])->name('profile');
    Route::get('settings', [VendorSettingsController::class, 'edit'])->name('settings.edit');
    Route::patch('settings', [VendorSettingsController::class, 'update'])->name('settings.update');

    // Analytics
    Route::get('analytics', [VendorAnalyticsController::class, 'index'])->name('analytics');
    Route::get('analytics/export', [VendorAnalyticsController::class, 'export'])->name('analytics.export');

    // Reviews
    Route::get('reviews', [VendorReviewController::class, 'index'])->name('reviews.index');
    Route::patch('reviews/{review}/toggle-hide', [VendorReviewController::class, 'toggleHide'])->name('reviews.toggle-hide');
    Route::post('reviews/{review}/reply', [VendorReviewController::class, 'reply'])->name('reviews.reply');

    // Earnings
    Route::get('earnings', [VendorEarningsController::class, 'index'])->name('earnings.index');
    Route::post('earnings/request-payout', [VendorEarningsController::class, 'requestPayout'])->name('earnings.request-payout');

    // Notifications
    Route::get('notifications', [VendorNotificationController::class, 'index'])->name('notifications.index');
    Route::patch('notifications/{notification}/read', [VendorNotificationController::class, 'markRead'])->name('notifications.read');
    Route::delete('notifications/{notification}', [VendorNotificationController::class, 'destroy'])->name('notifications.destroy');

    // Chat / Messaging
    Route::get('chat', [VendorChatController::class, 'inbox'])->name('chat.inbox');
    Route::get('chat/{conversation}', [VendorChatController::class, 'show'])->name('chat.show');
    Route::post('chat/{conversation}/send', [VendorChatController::class, 'sendMessage'])->name('chat.send');
    Route::get('chat/{conversation}/poll', [VendorChatController::class, 'pollMessages'])->name('chat.poll');
});
