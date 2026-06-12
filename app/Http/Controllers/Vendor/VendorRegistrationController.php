<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\VendorRegistrationRequest;
use App\Services\VendorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class VendorRegistrationController extends Controller
{
    public function __construct(private VendorService $vendorService)
    {
    }

    /**
     * Show vendor registration form.
     */
    public function create(): View|RedirectResponse
    {
        // If user already has a vendor profile, redirect
        if (auth()->user()->vendor) {
            return redirect()->route('vendor.dashboard');
        }

        return view('vendor.auth.register');
    }

    /**
     * Store a new vendor registration.
     */
    public function store(VendorRegistrationRequest $request): RedirectResponse
    {
        $this->vendorService->createVendor(
            auth()->id(),
            $request->validated()
        );

        return redirect()->route('vendor.dashboard')
            ->with('success', 'Pendaftaran vendor berhasil! Menunggu persetujuan admin.');
    }
}
