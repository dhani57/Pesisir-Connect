<x-vendor-layout :title="'Dashboard'">

{{-- Welcome & Quick Stats --}}
<div class="mb-8">
    <div class="bg-gradient-to-br from-ocean-600 via-ocean-700 to-ocean-900 rounded-2xl shadow-xl overflow-hidden relative">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-5"></div>
        <div class="relative p-6 sm:p-8 text-white">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <img src="{{ $vendor->logo_url }}" class="w-16 h-16 rounded-2xl object-cover border-2 border-white/20 shadow-lg" alt="{{ $vendor->shop_name }}">
                    <div>
                        <h2 class="text-2xl font-bold">{{ $vendor->shop_name }}</h2>
                        <p class="text-ocean-200 text-sm mt-0.5">Selamat datang kembali, {{ auth()->user()->name }}! 👋</p>
                    </div>
                </div>
                <span class="px-4 py-1.5 rounded-full text-xs font-bold {{ $vendor->status === 'approved' ? 'bg-emerald-400/20 text-emerald-100 ring-1 ring-emerald-400/30' : 'bg-amber-400/20 text-amber-100 ring-1 ring-amber-400/30' }}">
                    {{ $vendor->status_label }}
                </span>
            </div>

            {{-- Quick Stats Row --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">
                <div class="bg-white/10 backdrop-blur rounded-xl p-4">
                    <p class="text-ocean-200 text-xs font-medium">Pendapatan Bulan Ini</p>
                    <p class="text-xl font-bold mt-1">Rp {{ number_format($stats['revenueThisMonth'], 0, ',', '.') }}</p>
                </div>
                <div class="bg-white/10 backdrop-blur rounded-xl p-4">
                    <p class="text-ocean-200 text-xs font-medium">Pesanan Menunggu</p>
                    <p class="text-xl font-bold mt-1">{{ $stats['pendingOrders'] }}</p>
                </div>
                <div class="bg-white/10 backdrop-blur rounded-xl p-4">
                    <p class="text-ocean-200 text-xs font-medium">Rating Rata-rata</p>
                    <p class="text-xl font-bold mt-1">⭐ {{ $vendor->average_rating }}</p>
                </div>
                <div class="bg-white/10 backdrop-blur rounded-xl p-4">
                    <p class="text-ocean-200 text-xs font-medium">Total Produk</p>
                    <p class="text-xl font-bold mt-1">{{ $stats['totalProducts'] }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Main Dashboard Grid --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    {{-- Revenue Widget --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">💰 Pendapatan</h3>
        <div class="space-y-3">
            <div class="flex justify-between items-center"><span class="text-sm text-gray-600">Bulan ini</span><span class="font-bold text-gray-900">Rp {{ number_format($stats['revenueThisMonth'], 0, ',', '.') }}</span></div>
            <div class="flex justify-between items-center"><span class="text-sm text-gray-600">Bulan lalu</span><span class="font-semibold text-gray-700">Rp {{ number_format($stats['revenueLastMonth'], 0, ',', '.') }}</span></div>
            <div class="flex justify-between items-center"><span class="text-sm text-gray-600">Tahun ini</span><span class="font-semibold text-gray-700">Rp {{ number_format($stats['revenueThisYear'], 0, ',', '.') }}</span></div>
            <div class="pt-2 border-t">
                <span class="inline-flex items-center gap-1 text-sm font-semibold {{ $stats['growthPercentage'] >= 0 ? 'text-emerald-600' : 'text-red-600' }}">
                    @if($stats['growthPercentage'] >= 0) 📈 @else 📉 @endif
                    {{ $stats['growthPercentage'] }}% dari bulan lalu
                </span>
            </div>
        </div>
    </div>

    {{-- Orders Widget --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">📦 Pesanan</h3>
        <div class="space-y-3">
            <div class="flex justify-between items-center"><span class="text-sm text-gray-600">Menunggu</span><span class="font-bold text-amber-600">{{ $stats['pendingOrders'] }}</span></div>
            <div class="flex justify-between items-center"><span class="text-sm text-gray-600">Siap Kirim</span><span class="font-bold text-blue-600">{{ $stats['readyOrders'] }}</span></div>
            <div class="flex justify-between items-center"><span class="text-sm text-gray-600">Selesai (bulan ini)</span><span class="font-bold text-emerald-600">{{ $stats['completedThisMonth'] }}</span></div>
            <div class="flex justify-between items-center"><span class="text-sm text-gray-600">Dibatalkan</span><span class="font-bold text-red-600">{{ $stats['cancelledOrders'] }}</span></div>
        </div>
    </div>

    {{-- Products Widget --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-4">🏷️ Produk</h3>
        <div class="space-y-3">
            <div class="flex justify-between items-center"><span class="text-sm text-gray-600">Total Produk</span><span class="font-bold text-gray-900">{{ $stats['totalProducts'] }}</span></div>
            <div class="flex justify-between items-center"><span class="text-sm text-gray-600">Stok Habis</span><span class="font-bold {{ $stats['outOfStock'] > 0 ? 'text-red-600' : 'text-gray-600' }}">{{ $stats['outOfStock'] }}</span></div>
            @if($stats['topSellingProduct'])
                <div class="flex justify-between items-center"><span class="text-sm text-gray-600">Terlaris</span><span class="font-semibold text-ocean-600 text-sm truncate ml-2">{{ $stats['topSellingProduct']->name }}</span></div>
            @endif
            <div class="pt-2 border-t">
                <a href="{{ route('vendor.products.create') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-ocean-600 hover:text-ocean-700">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    Tambah Produk Baru
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Recent Orders & Top Products --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    {{-- Recent Orders --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-bold text-gray-900">Pesanan Terbaru</h3>
            <a href="{{ route('vendor.orders.index') }}" class="text-sm text-ocean-600 hover:text-ocean-700 font-medium">Lihat Semua →</a>
        </div>
        <div class="overflow-x-auto">
            @if($stats['recentOrders']->count() > 0)
                <table class="w-full text-sm">
                    <thead><tr class="text-xs text-gray-500 border-b bg-gray-50/50"><th class="px-4 py-3 text-left">Invoice</th><th class="px-4 py-3 text-left">Customer</th><th class="px-4 py-3 text-right">Total</th><th class="px-4 py-3 text-center">Status</th></tr></thead>
                    <tbody>
                        @foreach($stats['recentOrders'] as $order)
                        <tr class="border-b border-gray-50 hover:bg-gray-50/50">
                            <td class="px-4 py-3 font-medium text-gray-900">{{ Str::limit($order->invoice_number, 15) }}</td>
                            <td class="px-4 py-3 text-gray-600">{{ $order->customer->name ?? '-' }}</td>
                            <td class="px-4 py-3 text-right font-semibold">{{ $order->formatted_total }}</td>
                            <td class="px-4 py-3 text-center">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold {{ match($order->vendor_status) { 'pending' => 'bg-amber-100 text-amber-700', 'ready' => 'bg-blue-100 text-blue-700', 'completed' => 'bg-emerald-100 text-emerald-700', 'cancelled' => 'bg-red-100 text-red-700', default => 'bg-gray-100 text-gray-700' } }}">
                                    {{ match($order->vendor_status) { 'pending' => 'Menunggu', 'ready' => 'Siap', 'completed' => 'Selesai', 'cancelled' => 'Batal', default => $order->vendor_status } }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="p-8 text-center text-gray-500"><p>Belum ada pesanan.</p></div>
            @endif
        </div>
    </div>

    {{-- Top Products --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
            <h3 class="font-bold text-gray-900">Produk Terlaris</h3>
            <a href="{{ route('vendor.products.index') }}" class="text-sm text-ocean-600 hover:text-ocean-700 font-medium">Lihat Semua →</a>
        </div>
        @if($stats['topProducts']->count() > 0)
            <div class="divide-y divide-gray-50">
                @foreach($stats['topProducts'] as $product)
                <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50/50">
                    <div class="flex items-center gap-3">
                        <img src="{{ $product->thumbnail_url }}" class="w-10 h-10 rounded-lg object-cover" alt="">
                        <div>
                            <p class="font-medium text-gray-900 text-sm">{{ Str::limit($product->name, 30) }}</p>
                            <p class="text-xs text-gray-500">{{ $product->transactions_count ?? 0 }} penjualan</p>
                        </div>
                    </div>
                    <span class="font-semibold text-gray-900 text-sm">Rp {{ number_format($product->transactions_sum_total_price ?? 0, 0, ',', '.') }}</span>
                </div>
                @endforeach
            </div>
        @else
            <div class="p-8 text-center text-gray-500"><p>Belum ada data produk.</p></div>
        @endif
    </div>
</div>

{{-- Charts --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-bold text-gray-900 mb-4">📊 Tren Penjualan (30 Hari)</h3>
        <canvas id="salesChart" height="200"></canvas>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-bold text-gray-900 mb-4">📈 Distribusi Status Pesanan</h3>
        <canvas id="orderStatusChart" height="200"></canvas>
    </div>
</div>

{{-- Quick Actions --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
    <h3 class="font-bold text-gray-900 mb-4">⚡ Aksi Cepat</h3>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3">
        <a href="{{ route('vendor.products.create') }}" class="flex flex-col items-center gap-2 p-4 rounded-xl bg-ocean-50 hover:bg-ocean-100 transition-colors text-center">
            <svg class="w-6 h-6 text-ocean-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            <span class="text-xs font-semibold text-ocean-700">Tambah Produk</span>
        </a>
        <a href="{{ route('vendor.orders.index') }}" class="flex flex-col items-center gap-2 p-4 rounded-xl bg-amber-50 hover:bg-amber-100 transition-colors text-center">
            <svg class="w-6 h-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            <span class="text-xs font-semibold text-amber-700">Semua Pesanan</span>
        </a>
        <a href="{{ route('vendor.products.index') }}" class="flex flex-col items-center gap-2 p-4 rounded-xl bg-emerald-50 hover:bg-emerald-100 transition-colors text-center">
            <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            <span class="text-xs font-semibold text-emerald-700">Semua Produk</span>
        </a>
        <a href="{{ route('vendor.settings.edit') }}" class="flex flex-col items-center gap-2 p-4 rounded-xl bg-purple-50 hover:bg-purple-100 transition-colors text-center">
            <svg class="w-6 h-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/></svg>
            <span class="text-xs font-semibold text-purple-700">Pengaturan</span>
        </a>
        <a href="{{ route('vendor.profile') }}" class="flex flex-col items-center gap-2 p-4 rounded-xl bg-coral-50 hover:bg-coral-100 transition-colors text-center">
            <svg class="w-6 h-6 text-coral-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            <span class="text-xs font-semibold text-coral-700">Profil Toko</span>
        </a>
    </div>
</div>

{{-- Chart Scripts --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const salesData = @json($stats['salesData']);
    const labels = Object.keys(salesData);
    const values = Object.values(salesData);

    new Chart(document.getElementById('salesChart'), {
        type: 'line',
        data: {
            labels: labels.map(d => new Date(d).toLocaleDateString('id-ID', {day:'numeric',month:'short'})),
            datasets: [{
                label: 'Pendapatan',
                data: values,
                borderColor: '#0ea5e9',
                backgroundColor: 'rgba(14,165,233,0.1)',
                fill: true, tension: 0.4, borderWidth: 2,
                pointBackgroundColor: '#0ea5e9', pointRadius: 3
            }]
        },
        options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { callback: v => 'Rp ' + (v/1000) + 'k' } } } }
    });

    const statusData = @json($stats['orderStatusDistribution']);
    new Chart(document.getElementById('orderStatusChart'), {
        type: 'doughnut',
        data: {
            labels: Object.keys(statusData),
            datasets: [{
                data: Object.values(statusData),
                backgroundColor: ['#f59e0b', '#3b82f6', '#10b981', '#ef4444'],
                borderWidth: 0
            }]
        },
        options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
    });
});
</script>
</x-vendor-layout>
