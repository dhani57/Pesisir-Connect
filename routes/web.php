<?php

use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\ChatController;
use App\Http\Controllers\Frontend\CustomerDashboardController;
use App\Http\Controllers\Frontend\CustomerProfileController;
use App\Http\Controllers\Frontend\CustomerReviewController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Frontend Routes (Wisatawan / Public)
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/katalog', [HomeController::class, 'catalog'])->name('catalog');
Route::get('/produk/{slug}', [ProductController::class, 'show'])->name('produk.detail');
Route::get('/destinasi', [PageController::class, 'destinasi'])->name('destinasi');
Route::get('/tentang', [PageController::class, 'tentang'])->name('tentang');

// Help Pages
Route::get('/bantuan/cara-memesan', [PageController::class, 'caraMemesan'])->name('help.how-to-order');
Route::get('/bantuan/faq', [PageController::class, 'faq'])->name('help.faq');
Route::get('/bantuan/kebijakan-privasi', [PageController::class, 'kebijakanPrivasi'])->name('help.privacy-policy');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [CustomerDashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    // Checkout Flow (specific route before wildcard)
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/resume/{invoiceNumber}', [CheckoutController::class, 'resumePayment'])->name('checkout.resume');
    Route::match(['get', 'post'], '/checkout/{slug}', [CheckoutController::class, 'show'])->name('checkout');
    Route::get('/payment/finish/{invoiceNumber}', [CheckoutController::class, 'finish'])->name('checkout.finish');

    // Customer Reviews
    Route::post('/review/{transaction}', [CustomerReviewController::class, 'store'])->name('customer.review.store');
    Route::patch('/transaction/{transaction}/cancel', [CustomerReviewController::class, 'cancelTransaction'])->name('customer.transaction.cancel');

    // E-Ticket
    Route::get('/tiket/{invoiceNumber}', [CustomerDashboardController::class, 'ticket'])->name('customer.ticket');

    // Wishlist
    Route::get('/simpan', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/simpan/{product}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

    // Customer Profile
    Route::get('/profil/edit', [CustomerProfileController::class, 'edit'])->name('customer.profile.edit');
    Route::patch('/profil/update', [CustomerProfileController::class, 'update'])->name('customer.profile.update');

    // Chat / Messaging
    Route::get('/pesan', [ChatController::class, 'inbox'])->name('chat.inbox');
    Route::get('/pesan/{conversation}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/pesan/mulai', [ChatController::class, 'startConversation'])->name('chat.start');
    Route::post('/pesan/{conversation}/kirim', [ChatController::class, 'sendMessage'])->name('chat.send');
    Route::get('/pesan/{conversation}/poll', [ChatController::class, 'pollMessages'])->name('chat.poll');
    Route::get('/api/chat/unread', [ChatController::class, 'unreadCount'])->name('chat.unread');
});

// Midtrans Webhook (no auth — called by Midtrans servers)
Route::post('/midtrans/notification', [CheckoutController::class, 'notification'])->name('midtrans.notification');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // 1. Dashboard Metrik Global
    Route::get('/dashboard', \App\Http\Controllers\Admin\DashboardController::class)->name('admin.dashboard');

    // 2. Sistem Verifikasi Vendor
    Route::get('/vendors', [\App\Http\Controllers\Admin\VendorController::class, 'index'])->name('admin.vendors.index');
    Route::get('/vendors/{vendor}', [\App\Http\Controllers\Admin\VendorController::class, 'show'])->name('admin.vendors.show');
    Route::patch('/vendors/{vendor}/toggle', [\App\Http\Controllers\Admin\VendorController::class, 'toggleStatus'])->name('admin.vendors.toggle');

    // 3. Manajemen Kategori
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class, ['as' => 'admin'])->except(['show']);

    // 4. Manajemen Konten Destinasi
    Route::resource('destinations', \App\Http\Controllers\Admin\DestinationController::class, ['as' => 'admin'])->except(['show']);

    // 5. Audit Finansial Global
    Route::get('/transactions', [\App\Http\Controllers\Admin\TransactionController::class, 'index'])->name('admin.transactions.index');
    Route::get('/transactions/export', [\App\Http\Controllers\Admin\TransactionController::class, 'export'])->name('admin.transactions.export');
    Route::get('/transactions/{transaction}', [\App\Http\Controllers\Admin\TransactionController::class, 'show'])->name('admin.transactions.show');
    Route::patch('/transactions/{transaction}/status', [\App\Http\Controllers\Admin\TransactionController::class, 'updateStatus'])->name('admin.transactions.update-status');
    Route::get('/transactions/{transaction}/invoice-pdf', [\App\Http\Controllers\Admin\TransactionController::class, 'downloadInvoice'])->name('admin.transactions.invoice-pdf');

    // 6. Pengaturan Global
    Route::get('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('admin.settings.index');
    Route::post('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('admin.settings.update');
});
/*
|--------------------------------------------------------------------------
| Vendor Registration & Public Routes
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Vendor\VendorRegistrationController;
use App\Http\Controllers\Vendor\VendorSettingsController;

Route::middleware('auth')->group(function () {
    Route::get('/vendor/register', [VendorRegistrationController::class, 'create'])->name('vendor.register');
    Route::post('/vendor/register', [VendorRegistrationController::class, 'store']);
});

// Public vendor profile (accessible without auth)
Route::get('/toko/{vendor}', [VendorSettingsController::class, 'publicProfile'])->name('vendor.public-profile');

// Public customer profile (accessible without auth)
Route::get('/profil/{user}', [CustomerProfileController::class, 'show'])->name('customer.profile.show');

// Search autocomplete API (no auth required)
Route::get('/api/search/suggestions', [HomeController::class, 'searchSuggestions'])->name('search.suggestions');

/*
|--------------------------------------------------------------------------
| Include additional route files
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';
require __DIR__.'/vendor.php';

require __DIR__.'/auth.php';
require __DIR__.'/vendor.php';
