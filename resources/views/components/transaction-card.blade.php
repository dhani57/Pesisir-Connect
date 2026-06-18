@props(['trx', 'reviewedTransactionIds' => []])

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
                <span class="flex items-center gap-1"><x-heroicon-o-calendar class="w-4 h-4" /> {{ $trx->check_in->format('d M Y') }}</span>
                <span class="flex items-center gap-1"><x-heroicon-o-users class="w-4 h-4" /> {{ $trx->guests }} tamu</span>
                <span class="font-bold text-ocean-600">{{ $trx->formatted_total }}</span>
            </div>

            {{-- Action Buttons --}}
            <div class="flex flex-wrap gap-2 mt-3">
                @if($trx->status === 'pending')
                <a href="{{ route('checkout.resume', $trx->invoice_number) }}" class="px-3 py-1.5 text-xs font-semibold rounded-lg bg-amber-600 text-white hover:bg-amber-700 transition-colors flex items-center gap-1 shadow-sm">
                    Lanjutkan Pembayaran
                </a>
                <form action="{{ route('customer.transaction.cancel', $trx) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                    @csrf @method('PATCH')
                    <button type="submit" class="px-3 py-1.5 text-xs font-semibold rounded-lg border border-red-200 text-red-600 hover:bg-red-50 transition-colors">Batalkan</button>
                </form>
                @endif

                @if(in_array($trx->status, ['paid', 'completed']))
                <a href="{{ route('customer.ticket', $trx->invoice_number) }}" target="_blank" class="px-3 py-1.5 text-xs font-semibold rounded-lg bg-ocean-600 text-white hover:bg-ocean-700 transition-colors flex items-center gap-1 shadow-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                    Lihat Tiket
                </a>
                @endif

                @if($trx->vendor_status === 'completed' && !in_array($trx->id, $reviewedTransactionIds))
                <button @click="showReview = !showReview" class="px-3 py-1.5 text-xs font-semibold rounded-lg border border-ocean-200 text-ocean-600 hover:bg-ocean-50 transition-colors flex items-center gap-1">
                    <x-heroicon-s-star class="w-4 h-4 text-yellow-400" /> Beri Ulasan
                </button>
                @elseif(in_array($trx->id, $reviewedTransactionIds))
                <span class="px-3 py-1.5 text-xs font-medium rounded-lg bg-gray-50 text-gray-500 flex items-center gap-1">
                    <x-heroicon-s-check-circle class="w-4 h-4 text-emerald-500" /> Sudah Diulas
                </span>
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
