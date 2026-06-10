<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $product->name }} — PesisirConnect</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
</head>
<body class="antialiased bg-gray-50">

    <x-navbar :always-scrolled="true" />

    <main class="pt-24 pb-16 min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Breadcrumbs --}}
            <nav class="flex text-sm text-gray-500 mb-6" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="hover:text-ocean-600 transition-colors">Beranda</a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-gray-400 mx-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                            <a href="{{ route('catalog') }}" class="hover:text-ocean-600 transition-colors">Katalog</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-gray-400 mx-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                            <span class="text-gray-800 font-medium truncate w-32 md:w-auto">{{ $product->name }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- Kiri: Detail Info --}}
                <div class="lg:col-span-2 space-y-8">
                    {{-- Gambar --}}
                    <div class="rounded-2xl overflow-hidden bg-white shadow-sm border border-gray-100 h-[300px] md:h-[450px]">
                        <img src="{{ $product->thumbnail_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    </div>

                    {{-- Informasi Utama --}}
                    <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100 relative">
                        @auth
                            <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST" class="absolute top-6 right-6">
                                @csrf
                                <button type="submit" class="w-10 h-10 rounded-full flex items-center justify-center transition-colors {{ $isSaved ? 'bg-red-50 text-red-500 hover:bg-red-100' : 'bg-gray-50 text-gray-400 hover:bg-red-50 hover:text-red-500' }}" title="{{ $isSaved ? 'Hapus dari Simpanan' : 'Simpan Wisata' }}">
                                    <svg class="w-6 h-6" fill="{{ $isSaved ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                </button>
                            </form>
                        @endauth

                        <div class="flex flex-wrap items-center gap-3 mb-4 pr-12">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-ocean-50 text-ocean-700">{{ $product->category->name }}</span>
                            <span class="flex items-center text-sm text-gray-500">
                                <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                {{ $product->location }}
                            </span>
                            @if($product->total_reviews > 0)
                                <span class="flex items-center text-sm text-gray-500">
                                    <svg class="w-4 h-4 mr-1 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    {{ number_format($product->rating, 1) }} ({{ $product->total_reviews }} ulasan)
                                </span>
                            @endif
                        </div>

                        <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>
                        
                        <div class="prose prose-sm md:prose-base prose-ocean max-w-none text-gray-600 leading-relaxed">
                            {!! nl2br(e($product->description ?? $product->short_description)) !!}
                        </div>
                    </div>

                    {{-- Fasilitas --}}
                    @if(!empty($product->facilities))
                    <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100">
                        <h2 class="text-xl font-bold text-gray-900 mb-6">Fasilitas & Layanan</h2>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($product->facilities as $facility)
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <span class="text-sm font-medium text-gray-700">{{ $facility }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                </div>

                {{-- Kanan: Floating Booking Card --}}
                <div class="lg:col-span-1">
                    <div class="bg-white p-6 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 lg:sticky lg:top-28">
                        <div class="mb-6 pb-6 border-b border-gray-100">
                            <span class="text-sm text-gray-500 block mb-1">Harga mulai dari</span>
                            <div class="flex items-baseline gap-1">
                                <span class="text-3xl font-extrabold text-ocean-600">{{ $product->formatted_price }}</span>
                                <span class="text-sm font-medium text-gray-400">/{{ $product->price_unit }}</span>
                            </div>
                        </div>

                        @auth
                        <form action="{{ route('checkout', $product->slug) }}" method="POST" class="space-y-5">
                            @csrf
                            
                            {{-- Date Picker --}}
                            <div>
                                <label for="tanggal" class="block text-sm font-semibold text-gray-700 mb-2">Pilih Tanggal</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                    <input type="date" id="tanggal" name="tanggal" required
                                           min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                           class="w-full pl-10 pr-3 py-2.5 rounded-xl border-gray-200 text-sm focus:border-ocean-500 focus:ring-ocean-500">
                                </div>
                            </div>

                            {{-- Quantity --}}
                            <div>
                                <label for="jumlah" class="block text-sm font-semibold text-gray-700 mb-2">Jumlah / Pax</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                    </div>
                                    <input type="number" id="jumlah" name="jumlah" min="1" value="1" required
                                           class="w-full pl-10 pr-3 py-2.5 rounded-xl border-gray-200 text-sm focus:border-ocean-500 focus:ring-ocean-500">
                                </div>
                            </div>

                            {{-- CTA Button --}}
                            <button type="submit" class="w-full inline-flex justify-center items-center gap-2 px-4 py-3.5 bg-ocean-600 hover:bg-ocean-700 text-white text-sm font-bold rounded-xl transition-colors active:scale-[0.98] shadow-md shadow-ocean-600/20">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                Lanjut Pembayaran
                            </button>

                            <p class="text-center text-xs text-gray-400 mt-4 flex items-center justify-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                Proses checkout terenkripsi
                            </p>
                        </form>
                        @else
                        <div class="space-y-5">
                            {{-- Date Picker (Disabled) --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Tanggal</label>
                                <div class="relative opacity-50 cursor-not-allowed">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                    <input type="date" disabled
                                           class="w-full pl-10 pr-3 py-2.5 rounded-xl border-gray-200 text-sm bg-gray-50 cursor-not-allowed">
                                </div>
                            </div>

                            {{-- Quantity (Disabled) --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah / Pax</label>
                                <div class="relative opacity-50 cursor-not-allowed">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                    </div>
                                    <input type="number" disabled value="1"
                                           class="w-full pl-10 pr-3 py-2.5 rounded-xl border-gray-200 text-sm bg-gray-50 cursor-not-allowed">
                                </div>
                            </div>

                            {{-- CTA Button (Login) --}}
                            <a href="{{ route('login') }}" class="w-full inline-flex justify-center items-center gap-2 px-4 py-3.5 bg-gray-800 hover:bg-gray-900 text-white text-sm font-bold rounded-xl transition-colors active:scale-[0.98] shadow-md shadow-gray-800/20">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                                Login untuk Memesan
                            </a>
                        </div>
                        @endauth
                    </div>
                </div>

            </div>
        </div>
    </main>

    <x-footer />
</body>
</html>
