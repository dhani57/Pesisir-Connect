<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\VendorReview;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Menampilkan halaman detail produk wisata
     */
    public function show(string $slug): View
    {
        // Cari berdasarkan slug, atau fallback ke ID
        $product = Product::active()
            ->with(['category', 'vendor'])
            ->where('slug', $slug)
            ->orWhere('id', $slug)
            ->firstOrFail();

        $isSaved = false;
        if (auth()->check()) {
            $isSaved = \App\Models\Wishlist::where('user_id', auth()->id())
                ->where('product_id', $product->id)
                ->exists();
        }

        // ── Load Reviews ────────────────────────────────
        $reviews = VendorReview::visible()
            ->whereHas('transaction', fn ($q) => $q->where('product_id', $product->id))
            ->with(['user', 'transaction'])
            ->latest()
            ->paginate(10);

        // ── Rating Summary (breakdown per bintang) ──────
        $ratingBreakdown = VendorReview::visible()
            ->whereHas('transaction', fn ($q) => $q->where('product_id', $product->id))
            ->selectRaw('rating, COUNT(*) as count')
            ->groupBy('rating')
            ->pluck('count', 'rating')
            ->toArray();

        $totalReviews = array_sum($ratingBreakdown);
        $averageRating = $totalReviews > 0
            ? round(array_sum(array_map(fn ($r, $c) => $r * $c, array_keys($ratingBreakdown), $ratingBreakdown)) / $totalReviews, 1)
            : 0;

        $ratingSummary = [
            'average'   => $averageRating,
            'total'     => $totalReviews,
            'breakdown' => $ratingBreakdown,
        ];

        // ── Review Eligibility (untuk user login) ───────
        $canReview = false;
        $eligibleTransaction = null;

        if (auth()->check()) {
            $userId = auth()->id();

            // Cari transaksi completed yang belum di-review
            $eligibleTransaction = Transaction::where('user_id', $userId)
                ->where('product_id', $product->id)
                ->where('vendor_status', 'completed')
                ->whereDoesntHave('review')
                ->first();

            $canReview = $eligibleTransaction !== null;
        }

        return view('frontend.produk-detail', compact(
            'product',
            'isSaved',
            'reviews',
            'ratingSummary',
            'canReview',
            'eligibleTransaction',
        ));
    }
}
