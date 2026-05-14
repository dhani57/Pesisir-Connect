<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Katalog layanan wisata pesisir Lampung — sewa perahu, alat snorkeling, dan homestay di Pahawang, Krui, Teluk Kiluan.">

    <title>Katalog Wisata — PesisirConnect</title>

    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🌊</text></svg>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">

    <style>[x-cloak] { display: none !important; }</style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased" x-data="{ showFilters: false }">

    {{-- Navbar (scrolled state by default since no hero) --}}
    <nav class="fixed top-0 inset-x-0 z-50 bg-white/95 backdrop-blur-xl shadow-md transition-all duration-300" id="catalog-navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 md:h-20">
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <div class="w-9 h-9 md:w-10 md:h-10 rounded-xl bg-gradient-to-br from-ocean-500 to-ocean-700 flex items-center justify-center shadow-md">
                        <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <span class="text-lg md:text-xl font-bold text-gray-900">Pesisir<span class="text-ocean-500">Connect</span></span>
                </a>

                <div class="hidden md:flex items-center gap-1">
                    <a href="{{ route('home') }}" class="px-4 py-2 rounded-xl text-sm font-medium text-gray-700 hover:text-ocean-600 transition-colors">Beranda</a>
                    <a href="{{ route('catalog') }}" class="px-4 py-2 rounded-xl text-sm font-medium text-ocean-600 bg-ocean-50 transition-colors">Katalog</a>
                </div>

                <div class="hidden md:flex items-center gap-3">
                    @guest
                        <a href="{{ route('login') }}" class="px-4 py-2 rounded-xl text-sm font-medium text-gray-700 hover:text-ocean-600 transition-colors">Masuk</a>
                        <a href="{{ route('register') }}" class="btn-primary !py-2.5 !px-5 !text-xs">Daftar Gratis</a>
                    @else
                        <a href="{{ route('dashboard') }}" class="btn-primary !py-2.5 !px-5 !text-xs">Dashboard</a>
                    @endguest
                </div>

                {{-- Mobile back --}}
                <a href="{{ route('home') }}" class="md:hidden p-2 rounded-xl text-gray-600 hover:bg-gray-100 transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </a>
            </div>
        </div>
    </nav>

    {{-- Page Content --}}
    <main class="pt-20 md:pt-24 pb-12 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Page Header --}}
            <div class="mb-8">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Katalog Wisata</h1>
                <p class="text-sm text-gray-500 mt-1">Temukan layanan wisata terbaik di pesisir Lampung</p>
            </div>

            <div class="flex flex-col lg:flex-row gap-8">

                {{-- Sidebar Filters --}}
                <aside class="lg:w-64 shrink-0">
                    {{-- Mobile filter toggle --}}
                    <button @click="showFilters = !showFilters"
                            class="lg:hidden w-full flex items-center justify-between px-4 py-3 rounded-xl bg-white shadow-card text-sm font-medium text-gray-700 mb-4">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                            Filter
                        </span>
                        <svg class="w-4 h-4 transition-transform" :class="showFilters && 'rotate-180'" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    </button>

                    <form action="{{ route('catalog') }}" method="GET"
                          x-show="showFilters || window.innerWidth >= 1024"
                          x-cloak
                          class="space-y-6 bg-white rounded-2xl p-5 shadow-card lg:sticky lg:top-28"
                          id="catalog-filters">

                        {{-- Search --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-2">Pencarian</label>
                            <input type="text" name="search" value="{{ request('search') }}"
                                   placeholder="Cari layanan..."
                                   class="w-full rounded-xl border-gray-200 text-sm focus:border-ocean-400 focus:ring-ocean-400">
                        </div>

                        {{-- Category --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-2">Kategori</label>
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="category" value=""
                                           {{ !request('category') ? 'checked' : '' }}
                                           class="text-ocean-500 focus:ring-ocean-400 border-gray-300">
                                    <span class="text-sm text-gray-600">Semua Kategori</span>
                                </label>
                                @foreach($categories as $cat)
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="category" value="{{ $cat->slug }}"
                                               {{ request('category') === $cat->slug ? 'checked' : '' }}
                                               class="text-ocean-500 focus:ring-ocean-400 border-gray-300">
                                        <span class="text-sm text-gray-600">{{ $cat->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Location --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-2">Lokasi</label>
                            <select name="location"
                                    class="w-full rounded-xl border-gray-200 text-sm focus:border-ocean-400 focus:ring-ocean-400">
                                <option value="">Semua Lokasi</option>
                                @foreach($locations as $loc)
                                    <option value="{{ $loc }}" {{ request('location') === $loc ? 'selected' : '' }}>{{ $loc }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Sort --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-2">Urutkan</label>
                            <select name="sort"
                                    class="w-full rounded-xl border-gray-200 text-sm focus:border-ocean-400 focus:ring-ocean-400">
                                <option value="" {{ !request('sort') ? 'selected' : '' }}>Terbaru</option>
                                <option value="price_low" {{ request('sort') === 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                                <option value="price_high" {{ request('sort') === 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                                <option value="rating" {{ request('sort') === 'rating' ? 'selected' : '' }}>Rating Tertinggi</option>
                            </select>
                        </div>

                        <button type="submit" class="btn-primary w-full !py-2.5">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            Terapkan Filter
                        </button>

                        @if(request()->hasAny(['search', 'category', 'location', 'sort']))
                            <a href="{{ route('catalog') }}" class="block text-center text-xs text-gray-400 hover:text-coral-500 transition-colors">Reset semua filter</a>
                        @endif
                    </form>
                </aside>

                {{-- Products Grid --}}
                <div class="flex-1">
                    {{-- Results Count --}}
                    <div class="flex items-center justify-between mb-6">
                        <p class="text-sm text-gray-500">
                            Menampilkan <span class="font-semibold text-gray-900">{{ $products->total() }}</span> layanan
                        </p>
                    </div>

                    @if($products->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5 md:gap-6">
                            @foreach($products as $product)
                                <x-product-card :product="$product" />
                            @endforeach
                        </div>

                        {{-- Pagination --}}
                        <div class="mt-10">
                            {{ $products->withQueryString()->links() }}
                        </div>
                    @else
                        <div class="text-center py-20 bg-white rounded-2xl shadow-card">
                            <div class="w-20 h-20 mx-auto mb-5 rounded-2xl bg-gray-100 flex items-center justify-center">
                                <svg class="w-10 h-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                            </div>
                            <h3 class="text-gray-700 font-semibold text-lg mb-2">Tidak ditemukan</h3>
                            <p class="text-sm text-gray-400 max-w-sm mx-auto mb-6">Maaf, tidak ada layanan yang sesuai dengan filter Anda. Coba ubah kata kunci atau filter.</p>
                            <a href="{{ route('catalog') }}" class="btn-primary !py-2.5">Lihat Semua Layanan</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>

    <x-footer />

</body>
</html>
