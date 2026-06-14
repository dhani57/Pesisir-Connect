<?php

namespace App\Policies;

use App\Models\Transaction;
use App\Models\User;

/**
 * TransactionPolicy
 *
 * Authorizes actions on transactions for both vendor and customer contexts.
 */
class TransactionPolicy
{
    /**
     * Admins can do anything with any transaction.
     */
    public function before(User $user, string $ability): ?bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can view the transaction.
     * Either the customer who made it or the vendor who owns it.
     */
    public function view(User $user, Transaction $transaction): bool
    {
        if ($user->id === $transaction->user_id) {
            return true;
        }

        return $user->vendor?->id === $transaction->vendor_id;
    }

    /**
     * Determine whether the user (vendor) can update the transaction status.
     */
    public function updateStatus(User $user, Transaction $transaction): bool
    {
        return $user->vendor?->id === $transaction->vendor_id;
    }

    /**
     * Determine whether the customer can cancel the transaction.
     */
    public function cancel(User $user, Transaction $transaction): bool
    {
        return $user->id === $transaction->user_id && $transaction->status === 'pending';
    }

    /**
     * Determine whether the customer can review the transaction.
     */
    public function review(User $user, Transaction $transaction): bool
    {
        return $user->id === $transaction->user_id && $transaction->vendor_status === 'completed';
    }

    /**
     * Determine whether the vendor can send an invoice.
     */
    public function sendInvoice(User $user, Transaction $transaction): bool
    {
        return $user->vendor?->id === $transaction->vendor_id;
    }

    /**
     * Determine whether the vendor can download the invoice.
     */
    public function downloadInvoice(User $user, Transaction $transaction): bool
    {
        if ($user->id === $transaction->user_id) {
            return true;
        }

        return $user->vendor?->id === $transaction->vendor_id;
    }
}
