<x-vendor-layout :title="'Analitik'">
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div><h2 class="text-2xl font-bold text-gray-900">Analitik & Laporan</h2><p class="text-sm text-gray-500 mt-1">Pantau performa toko Anda</p></div>
    <div class="flex gap-2">
        <form method="GET" class="flex gap-2">
            @foreach(['7' => '7 Hari', '30' => '30 Hari', '90' => '90 Hari'] as $val => $label)
                <button type="submit" name="range" value="{{ $val }}" class="px-4 py-2 rounded-xl text-sm font-semibold transition-colors {{ $range == $val ? 'bg-ocean-500 text-white' : 'bg-white text-gray-700 border border-gray-200 hover:bg-gray-50' }}">{{ $label }}</button>
            @endforeach
        </form>
        <a href="{{ route('vendor.analytics.export') }}" class="px-4 py-2 rounded-xl text-sm font-semibold bg-emerald-500 text-white hover:bg-emerald-600 transition-colors">📥 Export CSV</a>
    </div>
</div>

{{-- Key Metrics --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    @foreach([['Total Penjualan', 'Rp '.number_format($totalSales, 0, ',', '.'), '💰', 'ocean'], ['Total Pesanan', $totalOrders, '📦', 'blue'], ['Rata-rata Order', 'Rp '.number_format($avgOrderValue, 0, ',', '.'), '📊', 'purple'], ['Total Pelanggan', $totalCustomers, '👥', 'emerald'], ['Pelanggan Repeat', $repeatRate.'%', '🔄', 'amber'], ['Rating', '⭐ '.$avgRating, '⭐', 'yellow'], ['Response Rate', $responseRate.'%', '💬', 'cyan'], ['Pelanggan Baru', $newCustomers, '🆕', 'pink']] as $m)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ $m[0] }}</p>
            <p class="text-xl font-bold text-gray-900 mt-2">{{ $m[1] }}</p>
        </div>
    @endforeach
</div>

{{-- Charts --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6"><h3 class="font-bold text-gray-900 mb-4">📈 Tren Pendapatan</h3><canvas id="revChart" height="200"></canvas></div>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6"><h3 class="font-bold text-gray-900 mb-4">📊 Tren Pesanan</h3><canvas id="ordChart" height="200"></canvas></div>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6"><h3 class="font-bold text-gray-900 mb-4">📋 Status Pesanan</h3><canvas id="statusChart" height="200"></canvas></div>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6"><h3 class="font-bold text-gray-900 mb-4">👥 Segmen Pelanggan</h3><canvas id="custChart" height="200"></canvas></div>
</div>

{{-- Top Products Table --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100"><h3 class="font-bold text-gray-900">🏆 Performa Produk</h3></div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead><tr class="text-xs text-gray-500 uppercase border-b bg-gray-50/50"><th class="px-4 py-3 text-left">Produk</th><th class="px-4 py-3 text-center">Penjualan</th><th class="px-4 py-3 text-right">Pendapatan</th></tr></thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($topProducts as $p)
                <tr class="hover:bg-gray-50/50"><td class="px-4 py-3 font-medium text-gray-900">{{ $p->name }}</td><td class="px-4 py-3 text-center">{{ $p->transactions_count ?? 0 }}</td><td class="px-4 py-3 text-right font-semibold">Rp {{ number_format($p->transactions_sum_total_price ?? 0, 0, ',', '.') }}</td></tr>
                @empty
                <tr><td colspan="3" class="px-4 py-8 text-center text-gray-500">Belum ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const rt = @json($revenueTrend); const ot = @json($ordersTrend); const sd = @json($orderStatusDist); const pm = @json($paymentMethods);
    new Chart(document.getElementById('revChart'), {type:'line',data:{labels:Object.keys(rt).map(d=>new Date(d).toLocaleDateString('id-ID',{day:'numeric',month:'short'})),datasets:[{label:'Pendapatan',data:Object.values(rt),borderColor:'#0ea5e9',backgroundColor:'rgba(14,165,233,0.1)',fill:true,tension:0.4,borderWidth:2}]},options:{responsive:true,plugins:{legend:{display:false}},scales:{y:{beginAtZero:true}}}});
    new Chart(document.getElementById('ordChart'), {type:'bar',data:{labels:Object.keys(ot).map(d=>new Date(d).toLocaleDateString('id-ID',{day:'numeric',month:'short'})),datasets:[{label:'Pesanan',data:Object.values(ot),backgroundColor:'#3b82f6',borderRadius:6}]},options:{responsive:true,plugins:{legend:{display:false}},scales:{y:{beginAtZero:true}}}});
    new Chart(document.getElementById('statusChart'), {type:'doughnut',data:{labels:Object.keys(sd),datasets:[{data:Object.values(sd),backgroundColor:['#f59e0b','#3b82f6','#10b981','#ef4444'],borderWidth:0}]},options:{responsive:true,plugins:{legend:{position:'bottom'}}}});
    new Chart(document.getElementById('custChart'), {type:'doughnut',data:{labels:['Baru','Repeat'],datasets:[{data:[{{ $newCustomers }},{{ $repeatCustomers }}],backgroundColor:['#8b5cf6','#06b6d4'],borderWidth:0}]},options:{responsive:true,plugins:{legend:{position:'bottom'}}}});
});
</script>
</x-vendor-layout>
