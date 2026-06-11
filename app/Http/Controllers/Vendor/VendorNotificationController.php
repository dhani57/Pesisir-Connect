<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\VendorNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class VendorNotificationController extends Controller
{
    public function index(): View
    {
        $vendor = auth()->user()->vendor;
        $notifications = $vendor->notifications()->orderByDesc('created_at')->paginate(20);
        $unreadCount = $vendor->unread_notifications_count;
        return view('vendor.notifications', compact('notifications', 'vendor', 'unreadCount'));
    }

    public function markRead(VendorNotification $notification): RedirectResponse
    {
        $vendor = auth()->user()->vendor;
        if ($notification->vendor_id !== $vendor->id) abort(403);
        $notification->markAsRead();
        return back()->with('success', 'Notifikasi ditandai sudah dibaca.');
    }

    public function destroy(VendorNotification $notification): RedirectResponse
    {
        $vendor = auth()->user()->vendor;
        if ($notification->vendor_id !== $vendor->id) abort(403);
        $notification->delete();
        return back()->with('success', 'Notifikasi dihapus.');
    }
}
