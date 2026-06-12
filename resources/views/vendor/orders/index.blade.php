<x-vendor-layout :title="'Pesanan'">
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900">Manajemen Pesanan</h2>
    <p class="text-sm text-gray-500 mt-1">Kelola dan pantau semua pesanan dari pelanggan</p>
</div>

{{-- Status Cards --}}
<div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-3 mb-6">
    @foreach([['Total', $statusCounts['total'], 'bg-gray-100 text-gray-700'], ['Menunggu', $statusCounts['pending'], 'bg-amber-100 text-amber-700'], ['Siap', $statusCounts['ready'], 'bg-blue-100 text-blue-700'], ['Selesai', $statusCounts['completed'], 'bg-emerald-100 text-emerald-700'], ['Dibatalkan', $statusCounts['cancelled'], 'bg-red-100 text-red-700'], ['Hari Ini', $statusCounts['today'], 'bg-ocean-100 text-ocean-700']] as $card)
        <div class="bg-white rounded-xl border border-gray-100 p-4 text-center shadow-sm">
            <p class="text-2xl font-bold">{{ $card[1] }}</p>
            <span class="inline-block mt-1 px-2 py-0.5 rounded-full text-xs font-semibold {{ $card[2] }}">{{ $card[0] }}</span>
        </div>
    @endforeach
</div>

{{-- Filters --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-6">
    <form method="GET" class="flex flex-col sm:flex-row flex-wrap gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari invoice, nama customer..." class="flex-1 min-w-[200px] rounded-xl border-gray-300 focus:border-ocean-500 focus:ring-ocean-500 text-sm">
        <select name="vendor_status" class="rounded-xl border-gray-300 focus:border-ocean-500 focus:ring-ocean-500 text-sm">
            <option value="">Semua Status</option>
            <option value="pending" {{ request('vendor_status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
            <option value="ready" {{ request('vendor_status') == 'ready' ? 'selected' : '' }}>Siap</option>
            <option value="completed" {{ request('vendor_status') == 'completed' ? 'selected' : '' }}>Selesai</option>
            <option value="cancelled" {{ request('vendor_status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
        </select>
        <input type="date" name="date_from" value="{{ request('date_from') }}" class="rounded-xl border-gray-300 focus:border-ocean-500 focus:ring-ocean-500 text-sm">
        <input type="date" name="date_to" value="{{ request('date_to') }}" class="rounded-xl border-gray-300 focus:border-ocean-500 focus:ring-ocean-500 text-sm">
        <button type="submit" class="bg-ocean-500 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-ocean-600 transition-colors">Filter</button>
    </form>
</div>

{{-- Orders Table --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    @if($orders->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead><tr class="text-xs text-gray-500 uppercase tracking-wider border-b bg-gray-50/50">
                    <th class="px-4 py-3 text-left">Invoice</th><th class="px-4 py-3 text-left">Customer</th><th class="px-4 py-3 text-left">Produk</th><th class="px-4 py-3 text-left">Tanggal</th><th class="px-4 py-3 text-right">Total</th><th class="px-4 py-3 text-center">Bayar</th><th class="px-4 py-3 text-center">Status</th><th class="px-4 py-3 text-center">Aksi</th>
                </tr></thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($orders as $order)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-4 py-3 font-mono text-xs font-medium text-gray-900">{{ Str::limit($order->invoice_number, 18) }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ $order->customer->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-600 text-xs">{{ Str::limit($order->product->name ?? '-', 25) }}</td>
                        <td class="px-4 py-3 text-gray-500 text-xs">{{ $order->created_at->format('d M Y') }}</td>
                        <td class="px-4 py-3 text-right font-semibold text-gray-900">{{ $order->formatted_total }}</td>
                        <td class="px-4 py-3 text-center"><span class="px-2 py-1 rounded-full text-xs font-semibold {{ $order->status === 'paid' ? 'bg-emerald-100 text-emerald-700' : ($order->status === 'pending' ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-700') }}">{{ ucfirst($order->status) }}</span></td>
                        <td class="px-4 py-3 text-center"><span class="px-2 py-1 rounded-full text-xs font-semibold {{ match($order->vendor_status) { 'pending' => 'bg-amber-100 text-amber-700', 'ready' => 'bg-blue-100 text-blue-700', 'completed' => 'bg-emerald-100 text-emerald-700', 'cancelled' => 'bg-red-100 text-red-700', default => 'bg-gray-100 text-gray-700' } }}">{{ match($order->vendor_status) { 'pending' => 'Menunggu', 'ready' => 'Siap', 'completed' => 'Selesai', 'cancelled' => 'Batal', default => $order->vendor_status } }}</span></td>
                        <td class="px-4 py-3 text-center"><a href="{{ route('vendor.orders.show', $order) }}" class="text-ocean-600 hover:text-ocean-700 font-semibold text-xs">Detail →</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100">{{ $orders->links() }}</div>
    @else
        <div class="p-12 text-center">
            <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-ocean-50 flex items-center justify-center"><svg class="w-8 h-8 text-ocean-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg></div>
            <h4 class="text-lg font-bold text-gray-900 mb-2">Belum Ada Pesanan</h4>
            <p class="text-gray-500 text-sm">Pesanan dari pelanggan akan muncul di sini.</p>
        </div>
    @endif
</div>
</x-vendor-layout>
