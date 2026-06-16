<?php

namespace App\Providers;

use App\Http\Middleware\IsVendor;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register vendor middleware alias
        Route::aliasMiddleware('vendor', IsVendor::class);

        // Register mail layout component alias
        \Illuminate\Support\Facades\Blade::component('emails.components.layout', 'emails.components.layout');

        // Authorization Gates (non-model-specific)
        Gate::define('view-vendor-dashboard', function (User $user) {
            return $user->role === 'vendor' && $user->vendor && $user->vendor->is_approved;
        });

        Gate::define('create-product', function (User $user) {
            return $user->role === 'vendor';
        });

        // Model-specific authorization is handled by Policies:
        // - ProductPolicy (auto-discovered for App\Models\Product)
        // - TransactionPolicy (auto-discovered for App\Models\Transaction)
        // - VendorReviewPolicy (auto-discovered for App\Models\VendorReview)
    }
}
