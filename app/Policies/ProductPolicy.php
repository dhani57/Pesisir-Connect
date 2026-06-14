<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

/**
 * ProductPolicy
 *
 * Authorizes vendor actions on products.
 * Admin users bypass all checks via the `before` method in AuthServiceProvider.
 */
class ProductPolicy
{
    /**
     * Admins can do anything with any product.
     */
    public function before(User $user, string $ability): ?bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can view the product.
     */
    public function view(User $user, Product $product): bool
    {
        return $user->vendor?->id === $product->vendor_id;
    }

    /**
     * Determine whether the user can update the product.
     */
    public function update(User $user, Product $product): bool
    {
        return $user->vendor?->id === $product->vendor_id;
    }

    /**
     * Determine whether the user can delete the product.
     */
    public function delete(User $user, Product $product): bool
    {
        return $user->vendor?->id === $product->vendor_id;
    }

    /**
     * Determine whether the user can toggle the product status.
     */
    public function toggleStatus(User $user, Product $product): bool
    {
        return $user->vendor?->id === $product->vendor_id;
    }
}
