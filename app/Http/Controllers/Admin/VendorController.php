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
     * Toggle the active status of a vendor.
     */
    public function toggleStatus(User $vendor): RedirectResponse
    {
        if ($vendor->role !== 'vendor') {
            return back()->withErrors(['message' => 'User ini bukan vendor.']);
        }

        $vendor->update([
            'is_active' => !$vendor->is_active
        ]);

        $status = $vendor->is_active ? 'diaktifkan (Approved)' : 'dinonaktifkan (Pending)';

        return back()->with('success', "Status vendor {$vendor->name} berhasil diperbarui menjadi {$status}.");
    }
}
