<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Services\VendorService;
use Illuminate\View\View;

class VendorDashboardController extends Controller
{
    public function __construct(private VendorService $vendorService)
    {
    }

    /**
     * Show vendor dashboard.
     */
    public function index(): View
    {
        $vendor = auth()->user()->vendor;
        $stats = $this->vendorService->getDashboardStats($vendor);

        return view('vendor.dashboard', compact('vendor', 'stats'));
    }
}
