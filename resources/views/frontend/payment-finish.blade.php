<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Status Pembayaran — PesisirConnect</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🌊</text></svg>">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200..800&display=swap" rel="stylesheet">
    <style>[x-cloak]{display:none!important}</style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50">
<x-navbar :always-scrolled="true" />
<main class="pt-24 pb-16 min-h-screen flex items-center justify-center">
<div class="max-w-lg w-full mx-auto px-4">
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 text-center">
    @if($transaction->status === 'paid')
        <div class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-emerald-50 flex items-center justify-center">
            <svg class="w-10 h-10 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Pembayaran Berhasil! 🎉</h2>
        <p class="text-gray-500 mb-6">Pesanan <strong>{{ $transaction->invoice_number }}</strong> sedang diproses.</p>
    @elseif($transaction->status === 'cancelled')
        <div class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-red-50 flex items-center justify-center">
            <svg class="w-10 h-10 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Pembayaran Gagal</h2>
        <p class="text-gray-500 mb-6">Transaksi <strong>{{ $transaction->invoice_number }}</strong> dibatalkan.</p>
    @else
        <div class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-amber-50 flex items-center justify-center">
            <svg class="w-10 h-10 text-amber-500 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Menunggu Pembayaran</h2>
        <p class="text-gray-500 mb-6">Pesanan <strong>{{ $transaction->invoice_number }}</strong> menunggu pembayaran Anda.</p>
    @endif

    <div class="bg-gray-50 rounded-xl p-4 mb-6 text-left space-y-2 text-sm">
        <div class="flex justify-between"><span class="text-gray-500">Layanan</span><span class="font-medium text-gray-900 text-right">{{ $transaction->product->name }}</span></div>
        <div class="flex justify-between"><span class="text-gray-500">Tanggal</span><span class="font-medium text-gray-900">{{ $transaction->check_in->format('d M Y') }}</span></div>
        <div class="flex justify-between"><span class="text-gray-500">Total</span><span class="font-bold text-ocean-600">{{ $transaction->formatted_total }}</span></div>
    </div>

    <a href="{{ route('dashboard') }}" class="w-full flex justify-center items-center gap-2 px-6 py-3.5 bg-ocean-600 hover:bg-ocean-700 text-white font-bold rounded-xl transition-colors">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
        Ke Dashboard Saya
    </a>
</div>
</div>
</main>
<x-footer />
</body>
</html>
