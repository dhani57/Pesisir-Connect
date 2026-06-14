<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\VendorNotification;
use App\Models\VendorReview;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * CustomerReviewController
 *
 * Allows authenticated customers to submit reviews for completed transactions.
 * Enforces: one review per transaction, only after vendor_status = 'completed'.
 */
class CustomerReviewController extends Controller
{
    /**
     * Store a new review for a completed transaction.
     */
    public function store(Request $request, Transaction $transaction): RedirectResponse
    {
        $user = auth()->user();

        // Verify ownership and completion status — via Policy
        $this->authorize('review', $transaction);

        // Prevent duplicate reviews
        $existingReview = VendorReview::where('user_id', $user->id)
            ->where('transaction_id', $transaction->id)
            ->exists();

        if ($existingReview) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk transaksi ini.');
        }

        $validated = $request->validate([
            'rating'      => 'required|integer|min:1|max:5',
            'review_text' => 'nullable|string|max:1000',
        ]);

        // Create the review
        VendorReview::create([
            'vendor_id'      => $transaction->vendor_id,
            'user_id'        => $user->id,
            'transaction_id' => $transaction->id,
            'rating'         => $validated['rating'],
            'review_text'    => $validated['review_text'] ?? null,
        ]);

        // Update product rating and review count
        $this->updateProductRating($transaction->product_id);

        // Notify vendor about the new review
        if ($transaction->vendor_id) {
            VendorNotification::send(
                $transaction->vendor_id,
                'new_review',
                'Ulasan Baru ⭐',
                $user->name . ' memberikan rating ' . $validated['rating'] .
                '/5 untuk pesanan #' . $transaction->invoice_number . '.',
                route('vendor.reviews.index')
            );
        }

        return back()->with('success', 'Terima kasih! Ulasan Anda berhasil dikirim.');
    }

    /**
     * Cancel a pending transaction.
     */
    public function cancelTransaction(Transaction $transaction): RedirectResponse
    {
        $this->authorize('cancel', $transaction);

        $user = auth()->user();

        // Can only cancel if payment is still pending
        if ($transaction->status !== 'pending') {
            return back()->with('error', 'Hanya pesanan dengan status "menunggu pembayaran" yang bisa dibatalkan.');
        }

        $transaction->update([
            'status'        => 'cancelled',
            'vendor_status' => 'cancelled',
        ]);

        // Restore stock
        $product = $transaction->product;
        if ($product && $product->stock !== null) {
            $product->increment('stock', $transaction->quantity);
        }

        return back()->with('success', 'Pesanan berhasil dibatalkan.');
    }

    /**
     * Recalculate and update product rating & review count based on all visible reviews.
     */
    private function updateProductRating(int $productId): void
    {
        $product = Product::find($productId);
        if (!$product || !$product->vendor_id) {
            return;
        }

        // Get all visible reviews for this vendor's products that match this product
        $reviews = VendorReview::where('is_hidden', false)
            ->whereHas('transaction', fn ($q) => $q->where('product_id', $productId))
            ->get();

        if ($reviews->isNotEmpty()) {
            $product->update([
                'rating'        => round($reviews->avg('rating'), 2),
                'total_reviews' => $reviews->count(),
            ]);
        }
    }
}
