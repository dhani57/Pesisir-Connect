<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VendorController extends Controller
{
    /**
     * Display a listing of the vendors.
     */
    public function index(): View
    {
        $vendors = User::where('role', 'vendor')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.vendors.index', compact('vendors'));
    }

    /**
     * Display the specified vendor details.
     */
    public function show(User $vendor): View
    {
        if ($vendor->role !== 'vendor') {
            abort(404, 'Vendor not found.');
        }

        return view('admin.vendors.show', compact('vendor'));
    }

    /**
     * Toggle the active status of a vendor.
     */
    public function toggleStatus(User $vendor): RedirectResponse
    {
        if ($vendor->role !== 'vendor') {
            return back()->withErrors(['message' => 'User ini bukan vendor.']);
        }

        $newActiveStatus = !$vendor->is_active;

        $vendor->update([
            'is_active' => $newActiveStatus
        ]);

        if ($vendor->vendor) {
            $vendor->vendor->update([
                'is_approved' => $newActiveStatus,
                'status' => $newActiveStatus ? 'approved' : 'suspended',
                'verified_at' => $newActiveStatus ? now() : null,
            ]);
        }

        $status = $newActiveStatus ? 'diaktifkan (Approved)' : 'dinonaktifkan (Suspended)';

        return back()->with('success', "Status vendor {$vendor->name} berhasil diperbarui menjadi {$status}.");
    }
}
