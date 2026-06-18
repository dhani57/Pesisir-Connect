<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Cara Memesan — PesisirConnect</title>
    <meta name="description" content="Panduan langkah demi langkah cara memesan layanan wisata pesisir di PesisirConnect.">

    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect width='100' height='100' rx='20' fill='%230ea5e9'/><text x='50' y='75' font-size='70' font-family='sans-serif' font-weight='bold' fill='white' text-anchor='middle'>PC</text></svg>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">

    <style>[x-cloak] { display: none !important; }</style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50">

    <x-navbar />

    <section class="relative pt-24 pb-16 bg-gradient-to-br from-ocean-900 to-ocean-950 overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
        <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center pt-8">
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white mb-4">Panduan <span class="text-ocean-400">Cara Memesan</span></h1>
            <p class="text-ocean-100 text-lg max-w-2xl mx-auto">Ikuti 4 langkah mudah ini untuk merencanakan liburan pesisir Anda melalui PesisirConnect secara aman dan nyaman.</p>
        </div>
    </section>

    <section class="py-16 md:py-24">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="hidden md:block absolute top-0 bottom-0 left-1/2 w-0.5 bg-ocean-200 -ml-0.5"></div>
            
            <div class="space-y-8">
                {{-- Step 1 --}}
                <div class="bg-white p-8 sm:p-10 rounded-3xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow flex flex-col md:flex-row gap-6 items-start">
                    <div class="w-16 h-16 shrink-0 bg-gradient-to-br from-ocean-500 to-ocean-600 text-white rounded-2xl flex items-center justify-center font-bold text-2xl shadow-lg shadow-ocean-500/30">
                        1
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Pilih Layanan & Destinasi</h3>
                        <p class="text-gray-600 leading-relaxed text-base">Gunakan fitur pencarian di Katalog atau jelajahi halaman Destinasi. Temukan perahu wisata, alat snorkeling, atau homestay yang paling pas dengan rencana liburan Anda.</p>
                    </div>
                </div>

                {{-- Step 2 --}}
                <div class="bg-white p-8 sm:p-10 rounded-3xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow flex flex-col md:flex-row gap-6 items-start">
                    <div class="w-16 h-16 shrink-0 bg-gradient-to-br from-ocean-500 to-ocean-600 text-white rounded-2xl flex items-center justify-center font-bold text-2xl shadow-lg shadow-ocean-500/30">
                        2
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Isi Detail Pesanan</h3>
                        <p class="text-gray-600 leading-relaxed text-base">Tentukan tanggal kunjungan dan jumlah tamu/item yang ingin disewa. Sistem akan otomatis menghitung total harga tanpa biaya tersembunyi. Klik "Pesan Sekarang" untuk melanjutkan.</p>
                    </div>
                </div>

                {{-- Step 3 --}}
                <div class="bg-white p-8 sm:p-10 rounded-3xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow flex flex-col md:flex-row gap-6 items-start">
                    <div class="w-16 h-16 shrink-0 bg-gradient-to-br from-ocean-500 to-ocean-600 text-white rounded-2xl flex items-center justify-center font-bold text-2xl shadow-lg shadow-ocean-500/30">
                        3
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Lakukan Pembayaran Aman</h3>
                        <p class="text-gray-600 leading-relaxed text-base">Selesaikan pembayaran secara online melalui gerbang pembayaran (Midtrans) kami. Anda dapat membayar menggunakan Virtual Account (Bank Transfer), E-Wallet, atau Kartu Kredit. Transaksi Anda 100% aman.</p>
                    </div>
                </div>

                {{-- Step 4 --}}
                <div class="bg-white p-8 sm:p-10 rounded-3xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow flex flex-col md:flex-row gap-6 items-start">
                    <div class="w-16 h-16 shrink-0 bg-gradient-to-br from-ocean-500 to-ocean-600 text-white rounded-2xl flex items-center justify-center font-bold text-2xl shadow-lg shadow-ocean-500/30">
                        4
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Dapatkan E-Tiket Anda</h3>
                        <p class="text-gray-600 leading-relaxed text-base">Setelah pembayaran berhasil diverifikasi, E-Tiket Anda akan langsung tersedia di menu Dashboard Anda dan dikirimkan via email. Tunjukkan tiket tersebut kepada vendor saat kedatangan.</p>
                    </div>
                </div>
            </div>

            <div class="mt-16 text-center">
                <a href="{{ route('catalog') }}" class="inline-flex items-center justify-center px-8 py-3 text-base font-semibold text-white bg-ocean-600 rounded-xl hover:bg-ocean-700 transition-colors shadow-lg shadow-ocean-500/30">Mulai Pesan Sekarang</a>
            </div>
        </div>
    </section>

    <x-footer />
</body>
</html>
