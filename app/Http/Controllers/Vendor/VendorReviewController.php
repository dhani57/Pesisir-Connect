<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\VendorReview;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VendorReviewController extends Controller
{
    public function index(Request $request): View
    {
        $vendor = auth()->user()->vendor;
        $query = $vendor->reviews()->with(['user', 'transaction.product']);

        if ($rating = $request->input('rating')) {
            $query->where('rating', $rating);
        }
        $sortBy = $request->input('sort', 'created_at');
        $sortDir = $request->input('dir', 'desc');
        if (in_array($sortBy, ['rating', 'created_at', 'helpful_count'])) {
            $query->orderBy($sortBy, $sortDir === 'asc' ? 'asc' : 'desc');
        }

        $reviews = $query->paginate(15)->withQueryString();
        $avgRating = $vendor->average_rating;
        $reviewCount = $vendor->review_count;
        $ratingDist = [];
        for ($i = 5; $i >= 1; $i--) {
            $ratingDist[$i] = $vendor->reviews()->where('rating', $i)->count();
        }
        $responseRate = $reviewCount > 0 ? round(($vendor->reviews()->whereNotNull('vendor_reply')->count() / $reviewCount) * 100, 1) : 0;

        return view('vendor.reviews.index', compact('reviews', 'vendor', 'avgRating', 'reviewCount', 'ratingDist', 'responseRate'));
    }

    public function toggleHide(VendorReview $review): RedirectResponse
    {
        $this->authorize('manage', $review);

        $review->update(['is_hidden' => !$review->is_hidden]);
        return back()->with('success', $review->is_hidden ? 'Ulasan disembunyikan.' : 'Ulasan ditampilkan.');
    }

    public function reply(Request $request, VendorReview $review): RedirectResponse
    {
        $this->authorize('manage', $review);

        $request->validate(['vendor_reply' => 'required|string|max:1000']);
        $review->update(['vendor_reply' => $request->input('vendor_reply'), 'vendor_reply_at' => now()]);
        return back()->with('success', 'Balasan berhasil dikirim.');
    }
}
