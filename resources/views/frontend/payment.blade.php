<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pembayaran — PesisirConnect</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🌊</text></svg>">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200..800&display=swap" rel="stylesheet">
    <style>[x-cloak]{display:none!important}</style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="{{ config('midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ $clientKey }}"></script>
</head>
<body class="antialiased bg-gray-50">
<x-navbar :always-scrolled="true" />
<main class="pt-24 pb-16 min-h-screen flex items-center justify-center">
<div class="max-w-lg w-full mx-auto px-4">
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 text-center">
    <div id="s-pending">
        <div class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-ocean-50 flex items-center justify-center">
            <svg class="w-10 h-10 text-ocean-500 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/></svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Menunggu Pembayaran</h2>
        <p class="text-gray-500 mb-1">Invoice: <strong>{{ $transaction->invoice_number }}</strong></p>
        <p class="text-sm text-gray-500 mb-6">Total: <strong class="text-2xl text-ocean-600">{{ $transaction->formatted_total }}</strong></p>
        <button type="button" id="btn-pay" class="w-full flex justify-center items-center gap-2 px-6 py-4 bg-ocean-600 hover:bg-ocean-700 text-white font-bold rounded-xl transition-all active:scale-[0.98] shadow-lg shadow-ocean-600/25">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
            Pilih Metode Pembayaran
        </button>
    </div>
    <div id="s-success" class="hidden">
        <div class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-emerald-50 flex items-center justify-center">
            <svg class="w-10 h-10 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-900 mb-2" id="suc-title">Pembayaran Berhasil! 🎉</h2>
        <p class="text-gray-500 mb-6" id="suc-msg">Pesanan Anda sedang diproses oleh vendor.</p>
        <a href="{{ route('dashboard') }}" class="w-full flex justify-center items-center gap-2 px-6 py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl transition-colors">Lihat Riwayat Pesanan</a>
    </div>
    <div id="s-failed" class="hidden">
        <div class="w-20 h-20 mx-auto mb-6 rounded-2xl bg-red-50 flex items-center justify-center">
            <svg class="w-10 h-10 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Pembayaran Dibatalkan</h2>
        <p class="text-gray-500 mb-6">Anda menutup jendela pembayaran.</p>
        <button type="button" id="btn-retry" class="w-full flex justify-center items-center gap-2 px-6 py-3.5 bg-ocean-600 hover:bg-ocean-700 text-white font-bold rounded-xl transition-colors mb-3">Coba Lagi</button>
        <a href="{{ route('dashboard') }}" class="w-full flex justify-center items-center px-6 py-3 border border-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-colors">Kembali ke Dashboard</a>
    </div>
</div>
</div>
</main>
<x-footer />
<script>
document.addEventListener('DOMContentLoaded',function(){
    var t=@json($snapToken);
    function show(id){['s-pending','s-success','s-failed'].forEach(function(s){document.getElementById(s).classList.add('hidden')});document.getElementById(id).classList.remove('hidden')}
    function pay(){window.snap.pay(t,{onSuccess:function(){show('s-success')},onPending:function(){show('s-success');document.getElementById('suc-title').textContent='Menunggu Pembayaran';document.getElementById('suc-msg').textContent='Silakan selesaikan pembayaran sesuai instruksi.'},onError:function(){show('s-failed')},onClose:function(){show('s-failed')}})}
    document.getElementById('btn-pay').addEventListener('click',pay);
    document.getElementById('btn-retry').addEventListener('click',pay);
});
</script>
</body>
</html>
