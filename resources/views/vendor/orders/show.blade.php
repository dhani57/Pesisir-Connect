<x-vendor-layout :title="'Detail Pesanan'">
<div class="max-w-5xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('vendor.orders.index') }}" class="p-2 rounded-lg hover:bg-gray-100"><svg class="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg></a>
        <div>
            <h2 class="text-xl font-bold text-gray-900">Pesanan #{{ $transaction->invoice_number }}</h2>
            <p class="text-xs text-gray-500">{{ $transaction->created_at->format('d M Y, H:i') }}</p>
        </div>
        <div class="ml-auto flex gap-2">
            <span class="px-3 py-1 rounded-full text-xs font-bold {{ $transaction->status === 'paid' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">Bayar: {{ ucfirst($transaction->status) }}</span>
            <span class="px-3 py-1 rounded-full text-xs font-bold {{ match($transaction->vendor_status) { 'pending' => 'bg-amber-100 text-amber-700', 'ready' => 'bg-blue-100 text-blue-700', 'completed' => 'bg-emerald-100 text-emerald-700', default => 'bg-red-100 text-red-700' } }}">{{ match($transaction->vendor_status) { 'pending' => 'Menunggu', 'ready' => 'Siap', 'completed' => 'Selesai', 'cancelled' => 'Dibatalkan', default => $transaction->vendor_status } }}</span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Product --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-900 mb-4">🏷️ Produk</h3>
                <div class="flex gap-4">
                    <img src="{{ $transaction->product->thumbnail_url ?? '' }}" class="w-24 h-24 rounded-xl object-cover" alt="">
                    <div class="flex-1">
                        <p class="font-bold text-gray-900">{{ $transaction->product->name ?? '-' }}</p>
                        <div class="mt-2 text-sm text-gray-600 space-y-1">
                            <p>📅 Check-in: <strong>{{ $transaction->check_in?->format('d M Y') }}</strong></p>
                            <p>📅 Check-out: <strong>{{ $transaction->check_out?->format('d M Y') }}</strong></p>
                            <p>👥 Tamu: <strong>{{ $transaction->guests }}</strong> · Qty: <strong>{{ $transaction->quantity }}</strong></p>
                        </div>
                        <div class="mt-3 pt-3 border-t flex justify-between">
                            <span class="text-sm text-gray-600">Harga satuan: Rp {{ number_format($transaction->unit_price, 0, ',', '.') }}</span>
                            <span class="font-bold text-gray-900 text-lg">{{ $transaction->formatted_total }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Customer --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-900 mb-4">👤 Pelanggan</h3>
                <div class="space-y-2 text-sm">
                    <p><span class="text-gray-500 w-24 inline-block">Nama:</span> <strong>{{ $transaction->customer->name ?? '-' }}</strong></p>
                    <p><span class="text-gray-500 w-24 inline-block">Email:</span> {{ $transaction->customer->email ?? '-' }}</p>
                    <p><span class="text-gray-500 w-24 inline-block">Telepon:</span> {{ $transaction->customer->phone ?? '-' }}</p>
                    @if($transaction->notes)
                        <p class="mt-3 p-3 bg-amber-50 rounded-xl text-amber-800"><span class="font-semibold">Catatan customer:</span> {{ $transaction->notes }}</p>
                    @endif
                </div>
            </div>

            {{-- Vendor Notes --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-900 mb-4">📝 Catatan Vendor</h3>
                @if($transaction->vendor_notes)
                    <p class="text-sm text-gray-700 p-3 bg-gray-50 rounded-xl mb-4">{{ $transaction->vendor_notes }}</p>
                @endif
                <form method="POST" action="{{ route('vendor.orders.add-notes', $transaction) }}">
                    @csrf
                    <textarea name="vendor_notes" rows="3" class="w-full rounded-xl border-gray-300 focus:border-ocean-500 focus:ring-ocean-500 text-sm" placeholder="Tambahkan catatan internal...">{{ old('vendor_notes') }}</textarea>
                    <button type="submit" class="mt-2 bg-ocean-500 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-ocean-600 transition-colors">Simpan Catatan</button>
                </form>
            </div>
        </div>

        {{-- Sidebar Actions --}}
        <div class="space-y-6">
            {{-- Status Update --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-900 mb-4">🔄 Ubah Status</h3>
                <form method="POST" action="{{ route('vendor.orders.update-status', $transaction) }}">
                    @csrf @method('PATCH')
                    <select name="vendor_status" class="w-full rounded-xl border-gray-300 focus:border-ocean-500 focus:ring-ocean-500 text-sm mb-3">
                        <option value="pending" {{ $transaction->vendor_status == 'pending' ? 'selected' : '' }}>Menunggu</option>
                        <option value="ready" {{ $transaction->vendor_status == 'ready' ? 'selected' : '' }}>Siap</option>
                        <option value="completed" {{ $transaction->vendor_status == 'completed' ? 'selected' : '' }}>Selesai</option>
                        <option value="cancelled" {{ $transaction->vendor_status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                    <button type="submit" class="w-full bg-ocean-500 text-white py-2.5 rounded-xl text-sm font-semibold hover:bg-ocean-600 transition-colors">Update Status</button>
                </form>
            </div>

            {{-- Quick Actions --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-900 mb-4">⚡ Aksi</h3>
                <div class="space-y-2">
                    <form method="POST" action="{{ route('vendor.orders.send-invoice', $transaction) }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2.5 rounded-xl text-sm font-medium hover:bg-gray-50 flex items-center gap-2 text-gray-700">📧 Kirim Invoice via Email</button>
                    </form>
                    <a href="{{ route('vendor.orders.invoice-pdf', $transaction) }}" target="_blank" class="block px-4 py-2.5 rounded-xl text-sm font-medium hover:bg-gray-50 flex items-center gap-2 text-gray-700">📄 Download Invoice PDF</a>
                    @if($transaction->customer?->phone)
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $transaction->customer->phone) }}" target="_blank" class="block px-4 py-2.5 rounded-xl text-sm font-medium hover:bg-gray-50 flex items-center gap-2 text-gray-700">💬 Hubungi via WhatsApp</a>
                    @endif
                </div>
            </div>

            {{-- Payment Info --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-bold text-gray-900 mb-4">💳 Pembayaran</h3>
                <div class="space-y-2 text-sm">
                    <p><span class="text-gray-500">Metode:</span> <strong>{{ ucfirst(str_replace('_', ' ', $transaction->payment_method)) }}</strong></p>
                    <p><span class="text-gray-500">Total:</span> <strong>{{ $transaction->formatted_total }}</strong></p>
                    @if($transaction->paid_at)
                        <p><span class="text-gray-500">Dibayar:</span> <strong>{{ $transaction->paid_at->format('d M Y, H:i') }}</strong></p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
</x-vendor-layout>
