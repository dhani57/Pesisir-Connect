<x-vendor-layout :title="'Notifikasi'">
<div class="mb-6 flex items-center justify-between">
    <div><h2 class="text-2xl font-bold text-gray-900">Notifikasi</h2><p class="text-sm text-gray-500 mt-1">{{ $unreadCount }} belum dibaca</p></div>
</div>

<div class="space-y-3">
    @forelse($notifications as $notif)
    <div class="bg-white rounded-2xl shadow-sm border {{ $notif->is_read ? 'border-gray-100' : 'border-ocean-200 bg-ocean-50/30' }} p-5 flex items-start gap-4 transition-all">
        <span class="text-2xl shrink-0 mt-0.5">{{ $notif->icon }}</span>
        <div class="flex-1 min-w-0">
            <div class="flex items-start justify-between gap-2">
                <div>
                    <p class="font-semibold text-gray-900 {{ !$notif->is_read ? 'text-ocean-900' : '' }}">{{ $notif->title }}</p>
                    <p class="text-sm text-gray-600 mt-1">{{ $notif->message }}</p>
                    <div class="flex items-center gap-3 mt-2">
                        <span class="text-xs text-gray-400">{{ $notif->created_at->diffForHumans() }}</span>
                        <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">{{ $notif->type_label }}</span>
                    </div>
                </div>
                <div class="flex items-center gap-1 shrink-0">
                    @if(!$notif->is_read)
                        <form method="POST" action="{{ route('vendor.notifications.read', $notif) }}">@csrf @method('PATCH')
                            <button type="submit" class="p-2 rounded-lg hover:bg-ocean-100 text-ocean-600" title="Tandai dibaca"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg></button>
                        </form>
                    @endif
                    @if($notif->action_url)
                        <a href="{{ $notif->action_url }}" class="p-2 rounded-lg hover:bg-gray-100 text-gray-500" title="Lihat"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg></a>
                    @endif
                    <form method="POST" action="{{ route('vendor.notifications.destroy', $notif) }}" onsubmit="return confirm('Hapus notifikasi ini?')">@csrf @method('DELETE')
                        <button type="submit" class="p-2 rounded-lg hover:bg-red-50 text-red-500" title="Hapus"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
        <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-ocean-50 flex items-center justify-center"><span class="text-3xl">🔔</span></div>
        <h4 class="text-lg font-bold text-gray-900 mb-2">Tidak Ada Notifikasi</h4>
        <p class="text-gray-500 text-sm">Semua notifikasi Anda akan muncul di sini.</p>
    </div>
    @endforelse
</div>
@if($notifications->hasPages())<div class="mt-6">{{ $notifications->links() }}</div>@endif
</x-vendor-layout>
