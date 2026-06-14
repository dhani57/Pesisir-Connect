<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\VendorApprovedMail;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class VendorController extends Controller
{
    /**
     * Display a listing of the vendors.
     */
    public function index(): View
    {
        $perPage = request('per_page', 10);
        $perPage = $perPage === 'all' ? 1000000 : (int) $perPage;
        $search = request('search');

        $vendors = User::where('role', 'vendor')
            ->when($search, function ($query, $search) {
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhereHas('vendor', function($vq) use ($search) {
                          $vq->where('shop_name', 'like', "%{$search}%");
                      });
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

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

        // Send approval email to vendor when activated
        if ($newActiveStatus) {
            Mail::to($vendor)->send(new VendorApprovedMail($vendor));
        }

        $status = $newActiveStatus ? 'diaktifkan (Approved)' : 'dinonaktifkan (Suspended)';

        return back()->with('success', "Status vendor {$vendor->name} berhasil diperbarui menjadi {$status}.");
    }
}
