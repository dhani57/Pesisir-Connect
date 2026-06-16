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
                            @if($product->vendor)
                            <span class="flex items-center text-sm text-gray-500 hover:text-ocean-600 transition-colors">
                                <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z"/></svg>
                                <a href="{{ route('vendor.public-profile', $product->vendor->id) }}">{{ $product->vendor->shop_name }}</a>
                            </span>
                            @endif
                            <span class="flex items-center text-sm text-gray-500">
                                    <svg class="w-4 h-4 mr-1 {{ $ratingSummary['total'] > 0 ? 'text-amber-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    {{ number_format($ratingSummary['average'], 1) }} ({{ $ratingSummary['total'] }} ulasan)
                                </span>
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

                    {{-- ══════════════════════════════════════════ --}}
                    {{-- Ulasan Pelanggan --}}
                    {{-- ══════════════════════════════════════════ --}}

                    {{-- Rating Summary --}}
                    <x-review-summary :ratingSummary="$ratingSummary" />

                    {{-- Review Form (hanya jika user eligible) --}}
                    @auth
                        @if($canReview && $eligibleTransaction)
                            <x-review-form :transaction="$eligibleTransaction" :product="$product" />
                        @endif
                    @endauth

                    {{-- Flash Messages --}}
                    @if(session('success'))
                    <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm flex items-center gap-3">
                        <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ session('success') }}
                    </div>
                    @endif
                    @if(session('error'))
                    <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm flex items-center gap-3">
                        <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                        {{ session('error') }}
                    </div>
                    @endif

                    {{-- Review List --}}
                    @if($reviews->count() > 0)
                    <div class="space-y-4">
                        @foreach($reviews as $review)
                            <x-review-card :review="$review" />
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    @if($reviews->hasPages())
                    <div class="mt-2">
                        {{ $reviews->withQueryString()->links() }}
                    </div>
                    @endif
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
                        @auth
                            @if(auth()->id() !== $product->vendor->user_id)
                            <div x-data="{ openChatModal: false }" class="mt-4 pt-4 border-t border-gray-100">
                                <button @click="openChatModal = true" type="button" class="w-full inline-flex justify-center items-center gap-2 px-4 py-3 bg-white hover:bg-gray-50 border-2 border-ocean-600 text-ocean-700 text-sm font-bold rounded-xl transition-colors active:scale-[0.98]">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                    Chat Vendor
                                </button>

                                {{-- Chat Modal --}}
                                <div x-show="openChatModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/50 backdrop-blur-sm" x-transition.opacity x-cloak>
                                    <div @click.away="openChatModal = false" class="bg-white rounded-2xl shadow-xl max-w-md w-full overflow-hidden" x-transition.scale.origin.bottom>
                                        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                                            <h3 class="font-bold text-lg text-gray-900">Kirim Pesan ke Vendor</h3>
                                            <button @click="openChatModal = false" class="text-gray-400 hover:text-gray-600">
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                            </button>
                                        </div>
                                        <form action="{{ route('chat.start') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="vendor_id" value="{{ $product->vendor_id }}">
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <div class="p-6">
                                                <div class="flex items-center gap-3 mb-4 bg-gray-50 p-3 rounded-xl border border-gray-100">
                                                    <img src="{{ $product->thumbnail_url }}" class="w-12 h-12 rounded-lg object-cover">
                                                    <div class="truncate">
                                                        <p class="text-xs text-gray-500">Tanya tentang:</p>
                                                        <p class="text-sm font-bold text-gray-900 truncate">{{ $product->name }}</p>
                                                    </div>
                                                </div>
                                                <label class="block text-sm font-medium text-gray-700 mb-2">Pesan Anda</label>
                                                <textarea name="message" rows="4" required placeholder="Halo, apakah layanan ini tersedia untuk tanggal..." class="w-full rounded-xl border-gray-300 focus:border-ocean-500 focus:ring-ocean-500 text-sm resize-none"></textarea>
                                            </div>
                                            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
                                                <button type="button" @click="openChatModal = false" class="btn-outline !py-2.5">Batal</button>
                                                <button type="submit" class="btn-primary !py-2.5">Kirim Pesan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endauth
                    </div>
                </div>

            </div>
        </div>
    </main>

    <x-footer />
</body>
</html>
