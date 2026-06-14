<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Welcome Banner --}}
            <div class="bg-gradient-to-br from-ocean-500 to-ocean-700 rounded-2xl shadow-lg overflow-hidden relative">
                <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
                <div class="relative p-8 sm:p-10 text-white flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
                    <div>
                        <h3 class="text-3xl font-bold mb-2">Halo, {{ Auth::user()->name }}! 👋</h3>
                        <p class="text-ocean-100 text-lg">Siap untuk petualangan selanjutnya di pesisir Lampung?</p>
                    </div>
                    <a href="{{ route('catalog') }}" class="shrink-0 bg-white text-ocean-600 font-semibold px-6 py-3 rounded-xl shadow-md hover:bg-ocean-50 transition-all duration-200 active:scale-95">
                        Mulai Eksplorasi
                    </a>
                </div>
            </div>

            {{-- Stats Cards --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 rounded-xl bg-ocean-50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-ocean-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z"/></svg>
                        </div>
                        <span class="text-xs font-medium text-gray-500">Total Booking</span>
                    </div>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_bookings'] }}</p>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="text-xs font-medium text-gray-500">Booking Aktif</span>
                    </div>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['active_bookings'] }}</p>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="text-xs font-medium text-gray-500">Selesai</span>
                    </div>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['completed'] }}</p>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 rounded-xl bg-violet-50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-violet-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="text-xs font-medium text-gray-500">Total Belanja</span>
                    </div>
                    <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($stats['total_spent'], 0, ',', '.') }}</p>
                </div>
            </div>

            {{-- Flash Messages --}}
            @if(session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm flex items-center gap-3">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm flex items-center gap-3">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                {{ session('error') }}
            </div>
            @endif

            {{-- Transaction History --}}
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100">
                <div class="p-6 sm:p-8 border-b border-gray-100">
                    <h3 class="text-xl font-bold text-gray-900">Riwayat Pesanan</h3>
                    <p class="text-sm text-gray-500 mt-1">Daftar transaksi dan booking layanan wisata Anda.</p>
                </div>

                <div class="p-6 sm:p-8 bg-gray-50/50">
                    @if($transactions->count() > 0)
                        <div class="space-y-4">
                            @foreach($transactions as $trx)
                            <div class="bg-white rounded-xl border border-gray-100 p-5 hover:shadow-md transition-shadow" x-data="{ showReview: false }">
                                <div class="flex flex-col sm:flex-row gap-4">
                                    {{-- Product Thumbnail --}}
                                    <div class="w-full sm:w-24 h-32 sm:h-20 rounded-lg overflow-hidden shrink-0 bg-gray-100">
                                        <img src="{{ $trx->product->thumbnail_url ?? '' }}" alt="{{ $trx->product->name ?? '' }}" class="w-full h-full object-cover">
                                    </div>
                                    {{-- Details --}}
                                    <div class="flex-1 min-w-0">
                                        <div class="flex flex-wrap items-start justify-between gap-2 mb-1">
                                            <div>
                                                <h4 class="font-bold text-gray-900">{{ $trx->product->name ?? 'Produk Dihapus' }}</h4>
                                                <p class="text-xs text-gray-500">{{ $trx->invoice_number }} · {{ $trx->created_at->translatedFormat('d M Y, H:i') }}</p>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                @php
                                                    $statusConfig = match($trx->status) {
                                                        'paid' => ['bg-emerald-100 text-emerald-700', 'Dibayar'],
                                                        'pending' => ['bg-amber-100 text-amber-700', 'Menunggu'],
                                                        'confirmed' => ['bg-blue-100 text-blue-700', 'Dikonfirmasi'],
                                                        'completed' => ['bg-emerald-100 text-emerald-700', 'Selesai'],
                                                        'cancelled' => ['bg-red-100 text-red-700', 'Dibatalkan'],
                                                        'refunded' => ['bg-gray-100 text-gray-700', 'Refund'],
                                                        default => ['bg-gray-100 text-gray-600', ucfirst($trx->status)],
                                                    };
                                                    $vendorStatusConfig = match($trx->vendor_status) {
                                                        'pending' => ['bg-amber-100 text-amber-700', 'Menunggu Vendor'],
                                                        'ready' => ['bg-blue-100 text-blue-700', 'Siap'],
                                                        'completed' => ['bg-emerald-100 text-emerald-700', 'Selesai'],
                                                        'cancelled' => ['bg-red-100 text-red-700', 'Dibatalkan'],
                                                        default => ['bg-gray-100 text-gray-600', $trx->vendor_status ?? '-'],
                                                    };
                                                @endphp
                                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full {{ $statusConfig[0] }}">{{ $statusConfig[1] }}</span>
                                                @if($trx->status === 'paid')
                                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full {{ $vendorStatusConfig[0] }}">{{ $vendorStatusConfig[1] }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-sm text-gray-500 mt-2">
                                            <span>📅 {{ $trx->check_in->format('d M Y') }}</span>
                                            <span>👥 {{ $trx->guests }} tamu</span>
                                            <span class="font-bold text-ocean-600">{{ $trx->formatted_total }}</span>
                                        </div>

                                        {{-- Action Buttons --}}
                                        <div class="flex flex-wrap gap-2 mt-3">
                                            @if($trx->status === 'pending')
                                            <form action="{{ route('customer.transaction.cancel', $trx) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="px-3 py-1.5 text-xs font-semibold rounded-lg border border-red-200 text-red-600 hover:bg-red-50 transition-colors">Batalkan</button>
                                            </form>
                                            @endif

                                            @if($trx->vendor_status === 'completed' && !in_array($trx->id, $reviewedTransactionIds))
                                            <button @click="showReview = !showReview" class="px-3 py-1.5 text-xs font-semibold rounded-lg border border-ocean-200 text-ocean-600 hover:bg-ocean-50 transition-colors">
                                                ⭐ Beri Ulasan
                                            </button>
                                            @elseif(in_array($trx->id, $reviewedTransactionIds))
                                            <span class="px-3 py-1.5 text-xs font-medium rounded-lg bg-gray-50 text-gray-500">✅ Sudah Diulas</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- Review Form (collapsible) --}}
                                @if($trx->vendor_status === 'completed' && !in_array($trx->id, $reviewedTransactionIds))
                                <div x-show="showReview" x-cloak x-transition class="mt-4 pt-4 border-t border-gray-100">
                                    <form action="{{ route('customer.review.store', $trx) }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">Rating</label>
                                            <div class="flex gap-1" x-data="{ rating: 5 }">
                                                <input type="hidden" name="rating" :value="rating">
                                                @for($i = 1; $i <= 5; $i++)
                                                <button type="button" @click="rating = {{ $i }}" class="text-2xl transition-transform hover:scale-110" :class="{{ $i }} <= rating ? 'text-amber-400' : 'text-gray-300'">★</button>
                                                @endfor
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <textarea name="review_text" rows="3" maxlength="1000" placeholder="Ceritakan pengalaman Anda..." class="w-full rounded-xl border-gray-200 text-sm focus:border-ocean-500 focus:ring-ocean-500"></textarea>
                                        </div>
                                        <button type="submit" class="px-4 py-2 text-sm font-semibold bg-ocean-600 text-white rounded-lg hover:bg-ocean-700 transition-colors">Kirim Ulasan</button>
                                    </form>
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>

                        <div class="mt-6">{{ $transactions->links() }}</div>
                    @else
                        <div class="text-center py-12">
                            <div class="w-20 h-20 mx-auto mb-5 rounded-2xl bg-ocean-50 flex items-center justify-center">
                                <svg class="w-10 h-10 text-ocean-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z"/></svg>
                            </div>
                            <h4 class="text-lg font-bold text-gray-900 mb-2">Belum Ada Transaksi</h4>
                            <p class="text-gray-500 max-w-sm mx-auto mb-6 text-sm">Yuk, temukan penginapan atau kapal untuk liburan Anda!</p>
                            <a href="{{ route('catalog') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-ocean-500 to-ocean-600 text-white text-sm font-semibold rounded-xl shadow-sm hover:from-ocean-600 hover:to-ocean-700 transition-all">
                                Eksplor Destinasi
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
