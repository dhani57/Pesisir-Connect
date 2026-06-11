<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\SettingsRequest;
use App\Models\Vendor;
use App\Services\VendorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class VendorSettingsController extends Controller
{
    public function __construct(private VendorService $vendorService)
    {
    }

    /**
     * Show public vendor profile.
     */
    public function profile(): View
    {
        $vendor = auth()->user()->vendor;
        $vendor->load(['products' => fn ($q) => $q->where('status', 'active')->take(4)]);

        $recentReviews = $vendor->reviews()
            ->visible()
            ->with('user')
            ->orderByDesc('created_at')
            ->take(10)
            ->get();

        return view('vendor.profile', compact('vendor', 'recentReviews'));
    }

    /**
     * Show vendor settings form.
     */
    public function edit(): View
    {
        $vendor = auth()->user()->vendor;
        $earningsThisMonth = $vendor->commissionLogs()
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('vendor_earning');

        $earningsAllTime = $vendor->total_earnings;

        return view('vendor.settings', compact('vendor', 'earningsThisMonth', 'earningsAllTime'));
    }

    /**
     * Update vendor settings.
     */
    public function update(SettingsRequest $request): RedirectResponse
    {
        $vendor = auth()->user()->vendor;
        $this->vendorService->updateVendor($vendor, $request->validated());

        return back()->with('success', 'Pengaturan berhasil disimpan!');
    }

    /**
     * Public vendor profile page (for customers).
     */
    public function publicProfile(Vendor $vendor): View
    {
        if (!$vendor->isActive()) {
            abort(404);
        }

        $vendor->load(['products' => fn ($q) => $q->where('status', 'active')->orderByDesc('is_featured')->take(8)]);

        $recentReviews = $vendor->reviews()
            ->visible()
            ->with('user')
            ->orderByDesc('created_at')
            ->take(10)
            ->get();

        return view('vendor.public-profile', compact('vendor', 'recentReviews'));
    }
}
