<x-admin-layout title="Detail Transaksi">
    <!-- Header -->
    <div class="sm:flex sm:items-center sm:justify-between mb-8">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.transactions.index') }}" class="p-2 rounded-lg hover:bg-gray-100 transition-colors">
                <svg class="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <div>
                <h2 class="text-xl font-bold leading-7 text-gray-900 sm:text-2xl">Transaksi #{{ $transaction->invoice_number }}</h2>
                <p class="mt-1 text-sm text-gray-500">Dibuat {{ $transaction->created_at->format('d M Y, H:i') }} · {{ $transaction->created_at->diffForHumans() }}</p>
            </div>
        </div>
        <div class="mt-4 sm:mt-0 flex items-center gap-2">
            <a href="{{ route('admin.transactions.invoice-pdf', $transaction) }}" target="_blank" class="inline-flex items-center gap-1.5 rounded-lg bg-white px-3 py-2 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
                Download Invoice
            </a>
        </div>
    </div>

    <!-- Status Badges -->
    <div class="flex flex-wrap gap-3 mb-8">
        <span class="inline-flex items-center rounded-full px-3 py-1 text-sm font-bold {{ match($transaction->status) { 'paid' => 'bg-emerald-100 text-emerald-700', 'pending' => 'bg-amber-100 text-amber-700', 'refunded' => 'bg-blue-100 text-blue-700', default => 'bg-rose-100 text-rose-700' } }}">
            💳 Bayar: {{ match($transaction->status) { 'paid' => 'Dibayar', 'pending' => 'Pending', 'refunded' => 'Refunded', 'cancelled' => 'Dibatalkan', default => ucfirst($transaction->status) } }}
        </span>
        <span class="inline-flex items-center rounded-full px-3 py-1 text-sm font-bold {{ match($transaction->vendor_status) { 'completed' => 'bg-emerald-100 text-emerald-700', 'ready' => 'bg-blue-100 text-blue-700', 'pending' => 'bg-amber-100 text-amber-700', default => 'bg-rose-100 text-rose-700' } }}">
            📦 Vendor: {{ match($transaction->vendor_status) { 'pending' => 'Menunggu', 'ready' => 'Siap', 'completed' => 'Selesai', 'cancelled' => 'Dibatalkan', default => $transaction->vendor_status } }}
        </span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Product Info -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <span class="text-lg">🏷️</span> Produk / Layanan
                </h3>
                <div class="flex gap-4">
                    <img src="{{ $transaction->product->thumbnail_url ?? '' }}" class="w-24 h-24 rounded-xl object-cover flex-shrink-0" alt="">
                    <div class="flex-1 min-w-0">
                        <p class="font-bold text-gray-900 truncate">{{ $transaction->product->name ?? '-' }}</p>
                        <p class="text-sm text-gray-500 mt-1">{{ $transaction->product->category->name ?? '' }} · {{ $transaction->product->location ?? '' }}</p>
                        <div class="mt-3 grid grid-cols-2 sm:grid-cols-4 gap-3 text-sm">
                            <div>
                                <span class="text-gray-500 block text-xs">Check-in</span>
                                <strong>{{ $transaction->check_in?->format('d M Y') ?? '-' }}</strong>
                            </div>
                            <div>
                                <span class="text-gray-500 block text-xs">Check-out</span>
                                <strong>{{ $transaction->check_out?->format('d M Y') ?? '-' }}</strong>
                            </div>
                            <div>
                                <span class="text-gray-500 block text-xs">Jumlah</span>
                                <strong>{{ $transaction->quantity }} pax</strong>
                            </div>
                            <div>
                                <span class="text-gray-500 block text-xs">Tamu</span>
                                <strong>{{ $transaction->guests }} orang</strong>
                            </div>
                        </div>
                        <div class="mt-3 pt-3 border-t flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1">
                            <span class="text-sm text-gray-600">Harga satuan: Rp {{ number_format($transaction->unit_price, 0, ',', '.') }}</span>
                            <span class="font-bold text-gray-900 text-lg">{{ $transaction->formatted_total }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Info -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <span class="text-lg">👤</span> Pelanggan
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-500 block text-xs">Nama</span>
                        <strong>{{ $transaction->customer->name ?? '-' }}</strong>
                    </div>
                    <div>
                        <span class="text-gray-500 block text-xs">Email</span>
                        <span>{{ $transaction->customer->email ?? '-' }}</span>
                    </div>
                </div>
                @if($transaction->notes)
                    <div class="mt-4 p-3 bg-amber-50 rounded-xl text-sm text-amber-800">
                        <span class="font-semibold">Catatan customer:</span> {{ $transaction->notes }}
                    </div>
                @endif
                @if($transaction->vendor_notes)
                    <div class="mt-3 p-3 bg-sky-50 rounded-xl text-sm text-sky-800">
                        <span class="font-semibold">Catatan vendor:</span> {{ $transaction->vendor_notes }}
                    </div>
                @endif
            </div>

            <!-- Vendor Info -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <span class="text-lg">🏪</span> Vendor
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-500 block text-xs">Nama Vendor</span>
                        <strong>{{ $transaction->vendor?->user?->name ?? '-' }}</strong>
                    </div>
                    <div>
                        <span class="text-gray-500 block text-xs">Nama Toko</span>
                        <span>{{ $transaction->vendor?->shop_name ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 block text-xs">Email</span>
                        <span>{{ $transaction->vendor?->user?->email ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 block text-xs">Telepon</span>
                        <span>{{ $transaction->vendor?->phone ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <!-- Review -->
            @if($review)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <span class="text-lg">⭐</span> Ulasan Pelanggan
                    </h3>
                    <div class="flex items-start gap-3">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-yellow-500 text-sm">{{ $review->stars_html }}</span>
                                <span class="text-sm font-semibold text-gray-700">{{ $review->rating }}/5</span>
                                <span class="text-xs text-gray-500">oleh {{ $review->user->name ?? '-' }}</span>
                            </div>
                            @if($review->review_text)
                                <p class="text-sm text-gray-700">{{ $review->review_text }}</p>
                            @endif
                            @if($review->vendor_reply)
                                <div class="mt-3 p-3 bg-gray-50 rounded-lg text-sm">
                                    <span class="font-semibold text-gray-600">Balasan vendor:</span>
                                    <p class="text-gray-700 mt-1">{{ $review->vendor_reply }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Payment Details -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <span class="text-lg">💳</span> Pembayaran
                </h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Metode</span>
                        <strong>{{ ucfirst(str_replace('_', ' ', $transaction->midtrans_payment_type ?? $transaction->payment_method ?? '-')) }}</strong>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Total</span>
                        <strong>{{ $transaction->formatted_total }}</strong>
                    </div>
                    @if($transaction->paid_at)
                        <div class="flex justify-between">
                            <span class="text-gray-500">Dibayar</span>
                            <strong>{{ $transaction->paid_at->format('d M Y, H:i') }}</strong>
                        </div>
                    @endif
                    @if($transaction->completed_at)
                        <div class="flex justify-between">
                            <span class="text-gray-500">Selesai</span>
                            <strong>{{ $transaction->completed_at->format('d M Y, H:i') }}</strong>
                        </div>
                    @endif
                    @if($transaction->midtrans_transaction_id)
                        <div class="flex justify-between">
                            <span class="text-gray-500">Midtrans ID</span>
                            <span class="font-mono text-xs">{{ Str::limit($transaction->midtrans_transaction_id, 18) }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Admin Status Override -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <span class="text-lg">🔧</span> Override Status
                </h3>
                <form method="POST" action="{{ route('admin.transactions.update-status', $transaction) }}" x-data="{ confirmOverride: false }">
                    @csrf @method('PATCH')
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Status Pembayaran</label>
                            <select name="status" class="w-full rounded-lg border-gray-300 text-sm focus:border-sky-500 focus:ring-sky-500">
                                <option value="pending" {{ $transaction->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="paid" {{ $transaction->status === 'paid' ? 'selected' : '' }}>Dibayar (Paid)</option>
                                <option value="cancelled" {{ $transaction->status === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                                <option value="refunded" {{ $transaction->status === 'refunded' ? 'selected' : '' }}>Refunded</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 mb-1">Status Vendor</label>
                            <select name="vendor_status" class="w-full rounded-lg border-gray-300 text-sm focus:border-sky-500 focus:ring-sky-500">
                                <option value="pending" {{ $transaction->vendor_status === 'pending' ? 'selected' : '' }}>Menunggu</option>
                                <option value="ready" {{ $transaction->vendor_status === 'ready' ? 'selected' : '' }}>Siap</option>
                                <option value="completed" {{ $transaction->vendor_status === 'completed' ? 'selected' : '' }}>Selesai</option>
                                <option value="cancelled" {{ $transaction->vendor_status === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
                        </div>
                        <button type="submit"
                            x-on:click.prevent="if(!confirmOverride) { confirmOverride = true; $event.target.textContent = 'Klik lagi untuk konfirmasi'; setTimeout(() => { confirmOverride = false; $event.target.textContent = 'Update Status'; }, 3000); } else { $el.closest('form').submit(); }"
                            class="w-full bg-sky-600 text-white py-2.5 rounded-xl text-sm font-semibold hover:bg-sky-700 transition-colors">
                            Update Status
                        </button>
                    </div>
                </form>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <span class="text-lg">⚡</span> Aksi Cepat
                </h3>
                <div class="space-y-2">
                    <a href="{{ route('admin.transactions.invoice-pdf', $transaction) }}" target="_blank" class="block px-4 py-2.5 rounded-xl text-sm font-medium hover:bg-gray-50 flex items-center gap-2 text-gray-700 transition-colors">
                        📄 Download Invoice PDF
                    </a>
                    @if($transaction->vendor_id)
                        <a href="{{ route('admin.vendors.show', $transaction->vendor?->user) }}" class="block px-4 py-2.5 rounded-xl text-sm font-medium hover:bg-gray-50 flex items-center gap-2 text-gray-700 transition-colors">
                            🏪 Lihat Vendor
                        </a>
                    @endif
                </div>
            </div>

            <!-- Timeline -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <span class="text-lg">📋</span> Timeline
                </h3>
                <div class="space-y-4">
                    <div class="flex gap-3">
                        <div class="w-2.5 h-2.5 mt-1.5 rounded-full bg-sky-500 flex-shrink-0"></div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">Dibuat</p>
                            <p class="text-xs text-gray-500">{{ $transaction->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                    @if($transaction->paid_at)
                        <div class="flex gap-3">
                            <div class="w-2.5 h-2.5 mt-1.5 rounded-full bg-emerald-500 flex-shrink-0"></div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">Dibayar</p>
                                <p class="text-xs text-gray-500">{{ $transaction->paid_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                    @endif
                    @if($transaction->completed_at)
                        <div class="flex gap-3">
                            <div class="w-2.5 h-2.5 mt-1.5 rounded-full bg-green-600 flex-shrink-0"></div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">Selesai</p>
                                <p class="text-xs text-gray-500">{{ $transaction->completed_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                    @endif
                    @if($transaction->status === 'cancelled')
                        <div class="flex gap-3">
                            <div class="w-2.5 h-2.5 mt-1.5 rounded-full bg-rose-500 flex-shrink-0"></div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900">Dibatalkan</p>
                                <p class="text-xs text-gray-500">{{ $transaction->updated_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
