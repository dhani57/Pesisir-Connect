<x-vendor-layout :title="'Pendapatan'">
<div class="mb-6"><h2 class="text-2xl font-bold text-gray-900">Pendapatan & Komisi</h2><p class="text-sm text-gray-500 mt-1">Pantau pendapatan dan riwayat pembayaran</p></div>

{{-- Summary --}}
<div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5"><p class="text-xs text-gray-500 font-semibold">Bulan Ini</p><p class="text-xl font-bold text-emerald-600 mt-2">Rp {{ number_format($summary['this_month'], 0, ',', '.') }}</p></div>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5"><p class="text-xs text-gray-500 font-semibold">Bulan Lalu</p><p class="text-xl font-bold text-gray-900 mt-2">Rp {{ number_format($summary['last_month'], 0, ',', '.') }}</p></div>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5"><p class="text-xs text-gray-500 font-semibold">Total Semua</p><p class="text-xl font-bold text-gray-900 mt-2">Rp {{ number_format($summary['all_time'], 0, ',', '.') }}</p></div>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5"><p class="text-xs text-gray-500 font-semibold">Menunggu Bayar</p><p class="text-xl font-bold text-amber-600 mt-2">Rp {{ number_format($summary['pending'], 0, ',', '.') }}</p></div>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5"><p class="text-xs text-gray-500 font-semibold">Tarif Komisi</p><p class="text-xl font-bold text-ocean-600 mt-2">{{ $summary['commission_rate'] }}%</p></div>
</div>

{{-- Payout Request --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h3 class="font-bold text-gray-900"><x-heroicon-o-banknotes class="w-5 h-5 inline-block mr-1.5 -mt-1 text-current"/> Pencairan Dana</h3>
            <p class="text-sm text-gray-500 mt-1">Minimum pencairan: Rp {{ number_format($minPayout, 0, ',', '.') }}</p>
        </div>
        @if($summary['pending'] >= $minPayout)
            <form method="POST" action="{{ route('vendor.earnings.request-payout') }}" onsubmit="return confirm('Yakin ingin mencairkan dana sebesar Rp {{ number_format($summary['pending'], 0, ',', '.') }}?')">
                @csrf
                <button type="submit" class="bg-gradient-to-r from-emerald-500 to-emerald-600 text-white font-bold px-6 py-3 rounded-xl shadow-lg hover:from-emerald-600 hover:to-emerald-700 transition-all">Cairkan Rp {{ number_format($summary['pending'], 0, ',', '.') }}</button>
            </form>
        @else
            <span class="text-sm text-gray-500 bg-gray-100 px-4 py-2 rounded-xl">Saldo belum mencapai minimum</span>
        @endif
    </div>
</div>

{{-- Commission Info --}}
<div class="bg-gradient-to-r from-ocean-50 to-blue-50 rounded-2xl border border-ocean-200 p-6 mb-8">
    <h3 class="font-bold text-ocean-900 mb-2"><x-heroicon-o-chart-bar class="w-5 h-5 inline-block mr-1.5 -mt-1 text-current"/> Cara Perhitungan Komisi</h3>
    <div class="text-sm text-ocean-800 space-y-1">
        <p><strong>Komisi = Total Transaksi × ({{ $summary['commission_rate'] }}% / 100)</strong></p>
        <p><strong>Pendapatan Vendor = Total Transaksi - Komisi</strong></p>
        <p class="mt-2 text-ocean-600">Contoh: Transaksi Rp 1.000.000 → Komisi Rp {{ number_format(1000000 * $summary['commission_rate'] / 100, 0, ',', '.') }} → Anda terima Rp {{ number_format(1000000 * (1 - $summary['commission_rate'] / 100), 0, ',', '.') }}</p>
    </div>
</div>

{{-- Earnings by Product --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
    <div class="px-6 py-4 border-b border-gray-100"><h3 class="font-bold text-gray-900"><x-heroicon-o-cube class="w-5 h-5 inline-block mr-1.5 -mt-1 text-current"/> Pendapatan per Produk</h3></div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead><tr class="text-xs text-gray-500 uppercase border-b bg-gray-50/50"><th class="px-4 py-3 text-left">Produk</th><th class="px-4 py-3 text-center">Transaksi</th><th class="px-4 py-3 text-right">Total Penjualan</th><th class="px-4 py-3 text-right">Komisi</th><th class="px-4 py-3 text-right">Pendapatan</th></tr></thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($earningsByProduct as $name => $data)
                <tr class="hover:bg-gray-50/50"><td class="px-4 py-3 font-medium text-gray-900">{{ $name }}</td><td class="px-4 py-3 text-center">{{ $data['count'] }}</td><td class="px-4 py-3 text-right">Rp {{ number_format($data['total_sales'], 0, ',', '.') }}</td><td class="px-4 py-3 text-right text-red-600">Rp {{ number_format($data['total_commission'], 0, ',', '.') }}</td><td class="px-4 py-3 text-right font-bold text-emerald-600">Rp {{ number_format($data['total_earning'], 0, ',', '.') }}</td></tr>
                @empty
                <tr><td colspan="5" class="px-4 py-8 text-center text-gray-500">Belum ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Payment History --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100"><h3 class="font-bold text-gray-900"><x-heroicon-o-building-library class="w-6 h-6 inline-block mr-1.5 -mt-1 text-gray-500"/> Riwayat Pembayaran</h3></div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead><tr class="text-xs text-gray-500 uppercase border-b bg-gray-50/50"><th class="px-4 py-3 text-left">Tanggal</th><th class="px-4 py-3 text-left">Periode</th><th class="px-4 py-3 text-right">Jumlah</th><th class="px-4 py-3 text-center">Status</th><th class="px-4 py-3 text-left">Referensi</th></tr></thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($paymentHistory as $payout)
                <tr class="hover:bg-gray-50/50"><td class="px-4 py-3 text-gray-700">{{ $payout->created_at->format('d M Y') }}</td><td class="px-4 py-3 text-gray-500 text-xs">{{ $payout->period_start->format('d M') }} - {{ $payout->period_end->format('d M Y') }}</td><td class="px-4 py-3 text-right font-bold">{{ $payout->formatted_amount }}</td><td class="px-4 py-3 text-center"><span class="px-2 py-1 rounded-full text-xs font-semibold bg-{{ $payout->status_color }}-100 text-{{ $payout->status_color }}-700">{{ $payout->status_label }}</span></td><td class="px-4 py-3 text-gray-500 text-xs font-mono">{{ $payout->reference_number ?? '-' }}</td></tr>
                @empty
                <tr><td colspan="5" class="px-4 py-8 text-center text-gray-500">Belum ada riwayat pembayaran.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($paymentHistory->hasPages())<div class="px-6 py-4 border-t border-gray-100">{{ $paymentHistory->links() }}</div>@endif
</div>
</x-vendor-layout>
