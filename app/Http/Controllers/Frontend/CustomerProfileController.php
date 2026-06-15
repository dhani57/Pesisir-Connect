<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use App\Models\VendorReview;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

/**
 * CustomerProfileController
 *
 * Handles the public customer profile view and profile update
 * with avatar upload, bio, phone number, and address management.
 */
class CustomerProfileController extends Controller
{
    /**
     * Display a customer's public profile.
     */
    public function show(User $user): View
    {
        // Only allow viewing customer profiles
        if ($user->role !== 'customer') {
            abort(404);
        }

        // Statistics
        $stats = [
            'total_bookings' => Transaction::where('user_id', $user->id)->count(),
            'completed'      => Transaction::where('user_id', $user->id)
                                    ->where('vendor_status', 'completed')->count(),
            'total_spent'    => Transaction::where('user_id', $user->id)
                                    ->where('status', 'paid')->sum('total_price'),
            'member_since'   => $user->created_at,
        ];

        // Public reviews written by this customer
        $reviews = VendorReview::where('user_id', $user->id)
            ->visible()
            ->with(['vendor', 'transaction.product'])
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('frontend.customer-profile', compact('user', 'stats', 'reviews'));
    }

    /**
     * Show the customer profile edit form.
     */
    public function edit(): View
    {
        $user = auth()->user();

        return view('frontend.customer-profile-edit', compact('user'));
    }

    /**
     * Update the customer's profile.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'phone'   => ['nullable', 'string', 'max:20'],
            'bio'     => ['nullable', 'string', 'max:500'],
            'address' => ['nullable', 'string', 'max:255'],
            'avatar'  => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if it exists locally
            if ($user->avatar && file_exists(public_path($user->avatar))) {
                @unlink(public_path($user->avatar));
            }

            $file = $request->file('avatar');
            $filename = 'avatars/' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('avatars'), $user->id . '_' . time() . '.' . $file->getClientOriginalExtension());
            $validated['avatar'] = $filename;
        }

        $user->update($validated);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}
