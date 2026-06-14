<?php

namespace App\Policies;

use App\Models\User;
use App\Models\VendorReview;

/**
 * VendorReviewPolicy
 *
 * Authorizes vendor actions on reviews (toggle hide, reply).
 */
class VendorReviewPolicy
{
    /**
     * Admins can do anything with any review.
     */
    public function before(User $user, string $ability): ?bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the vendor can manage the review.
     */
    public function manage(User $user, VendorReview $review): bool
    {
        return $user->vendor?->id === $review->vendor_id;
    }
}
