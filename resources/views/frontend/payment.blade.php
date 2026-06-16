@php
    $product = $transaction->product;
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pembayaran — {{ $transaction->invoice_number }} — PesisirConnect</title>
    
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🌊</text></svg>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300..800&display=swap" rel="stylesheet">
    <style>[x-cloak] { display: none !important; }</style>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- Midtrans Snap.js --}}
    <script src="{{ config('midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ $clientKey }}"></script>
</head>
<body class="antialiased bg-gray-50 flex flex-col min-h-screen">
    
    <x-navbar :always-scrolled="true" />

    <main class="flex-grow pt-24 pb-16" x-data="paymentGateway()">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center mb-10">
                <h1 class="text-3xl font-bold text-gray-900 mb-3">Penyelesaian Pembayaran</h1>
                <p class="text-gray-500">Selesaikan pembayaran Anda secara aman melalui payment gateway kami.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 items-start">
                
                {{-- Left Column: Status & Action --}}
                <div class="lg:col-span-3 space-y-6">
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 overflow-hidden relative">
                        
                        {{-- Background Decoration --}}
                        <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 rounded-full bg-ocean-50/50 blur-2xl"></div>

                        {{-- State: PENDING --}}
                        <div x-show="status === 'pending'" x-transition x-cloak class="relative z-10 text-center py-6">
                            <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-ocean-50 flex items-center justify-center shadow-inner">
                                <svg class="w-12 h-12 text-ocean-600 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-3">Menunggu Pembayaran</h2>
                            <p class="text-gray-500 mb-8 max-w-sm mx-auto leading-relaxed">Silakan klik tombol di bawah ini untuk memunculkan halaman pembayaran yang aman.</p>
                            
                            <button @click="openSnap" type="button" class="inline-flex justify-center items-center gap-3 px-8 py-4 bg-ocean-600 hover:bg-ocean-700 text-white font-bold rounded-2xl transition-all active:scale-[0.98] shadow-xl shadow-ocean-600/20 w-full sm:w-auto">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                                Lanjutkan Pembayaran
                            </button>
                        </div>

                        {{-- State: SUCCESS --}}
                        <div x-show="status === 'success'" x-transition x-cloak class="relative z-10 text-center py-6">
                            <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-emerald-50 flex items-center justify-center shadow-inner">
                                <svg class="w-12 h-12 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-3">Pembayaran Berhasil! 🎉</h2>
                            <p class="text-gray-500 mb-8 max-w-sm mx-auto leading-relaxed">Terima kasih, pembayaran Anda telah kami terima. Vendor akan segera memproses pesanan Anda.</p>
                            
                            <a href="{{ route('dashboard') }}" class="inline-flex justify-center items-center gap-2 px-8 py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-2xl transition-colors w-full sm:w-auto shadow-lg shadow-emerald-600/20">
                                Lihat Tiket / Pesanan Saya
                            </a>
                        </div>

                        {{-- State: WAITING (Pending Midtrans like Indomaret/Transfer) --}}
                        <div x-show="status === 'waiting'" x-transition x-cloak class="relative z-10 text-center py-6">
                            <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-amber-50 flex items-center justify-center shadow-inner">
                                <svg class="w-12 h-12 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-3">Menunggu Pelunasan</h2>
                            <p class="text-gray-500 mb-8 max-w-sm mx-auto leading-relaxed">Selesaikan pembayaran sesuai instruksi yang diberikan oleh bank atau gerai yang Anda pilih.</p>
                            
                            <a href="{{ route('dashboard') }}" class="inline-flex justify-center items-center gap-2 px-8 py-4 bg-gray-800 hover:bg-gray-900 text-white font-bold rounded-2xl transition-colors w-full sm:w-auto shadow-lg shadow-gray-800/20">
                                Kembali ke Dashboard
                            </a>
                        </div>

                        {{-- State: FAILED --}}
                        <div x-show="status === 'failed'" x-transition x-cloak class="relative z-10 text-center py-6">
                            <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-red-50 flex items-center justify-center shadow-inner">
                                <svg class="w-12 h-12 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-3">Pembayaran Dibatalkan</h2>
                            <p class="text-gray-500 mb-8 max-w-sm mx-auto leading-relaxed">Anda menutup halaman pembayaran atau terjadi kegagalan sistem. Jangan khawatir, Anda bisa mencoba lagi.</p>
                            
                            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                                <button @click="openSnap" type="button" class="w-full sm:w-auto flex justify-center items-center gap-2 px-8 py-4 bg-ocean-600 hover:bg-ocean-700 text-white font-bold rounded-2xl transition-colors shadow-lg shadow-ocean-600/20">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                    Coba Lagi
                                </button>
                                <a href="{{ route('dashboard') }}" class="w-full sm:w-auto flex justify-center items-center px-8 py-4 border-2 border-gray-200 text-gray-700 font-bold rounded-2xl hover:bg-gray-50 transition-colors">
                                    Kembali
                                </a>
                            </div>
                        </div>

                    </div>

                    {{-- Security Badges --}}
                    <div class="flex items-center justify-center gap-6 text-gray-400">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8z"/></svg>
                            <span class="text-sm font-medium">Pembayaran Terenkripsi</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M11 7h2v2h-2zm0 4h2v6h-2zm1-9C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/></svg>
                            <span class="text-sm font-medium">Midtrans Gateway</span>
                        </div>
                    </div>
                </div>

                {{-- Right Column: Summary --}}
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 lg:sticky lg:top-28">
                        <h3 class="text-lg font-bold text-gray-900 mb-5 border-b border-gray-100 pb-4">Ringkasan Pesanan</h3>
                        
                        <div class="space-y-4 mb-6">
                            {{-- Product Item --}}
                            <div class="flex gap-4">
                                <div class="w-16 h-16 rounded-xl overflow-hidden bg-gray-100 shrink-0 border border-gray-50">
                                    <img src="{{ $product->thumbnail_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-900 text-sm leading-tight mb-1">{{ $product->name }}</h4>
                                    <p class="text-xs text-gray-500 line-clamp-1">{{ $product->location }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 rounded-2xl p-5 mb-6 space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Invoice</span>
                                <span class="font-semibold text-gray-900 uppercase">#{{ $transaction->invoice_number }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Tanggal Transaksi</span>
                                <span class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($transaction->created_at)->translatedFormat('d M Y') }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Check-in</span>
                                <span class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($transaction->check_in)->translatedFormat('d M Y') }}</span>
                            </div>
                        </div>

                        <div class="space-y-3 text-sm border-b border-gray-100 pb-5 mb-5">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Kuantitas</span>
                                <span class="font-medium text-gray-900">{{ $transaction->quantity }} {{ $product->price_unit }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Harga Satuan</span>
                                <span class="font-medium text-gray-900">Rp {{ number_format($transaction->unit_price, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center bg-ocean-50/50 -mx-6 -mb-6 px-6 py-5 rounded-b-3xl border-t border-ocean-100">
                            <span class="text-base font-bold text-gray-900">Total Tagihan</span>
                            <span class="text-2xl font-extrabold text-ocean-600">{{ $transaction->formatted_total }}</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <x-footer />

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('paymentGateway', () => ({
                status: 'pending', // pending, success, waiting, failed
                token: '{{ $snapToken }}',
                
                init() {
                    // Otomatis memunculkan popup pembayaran ketika halaman selesai dimuat (UX yang baik)
                    setTimeout(() => {
                        this.openSnap();
                    }, 500);
                },

                openSnap() {
                    if(!this.token) return;
                    
                    window.snap.pay(this.token, {
                        onSuccess: (result) => {
                            this.status = 'success';
                        },
                        onPending: (result) => {
                            this.status = 'waiting';
                        },
                        onError: (result) => {
                            this.status = 'failed';
                        },
                        onClose: () => {
                            this.status = 'failed';
                        }
                    });
                }
            }))
        })
    </script>
</body>
</html>
