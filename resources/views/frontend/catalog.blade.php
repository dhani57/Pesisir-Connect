<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    {{-- SEO Meta Tags --}}
    <meta name="description" content="Katalog layanan wisata pesisir Lampung — sewa perahu, alat snorkeling, dan homestay di Pahawang, Krui, Teluk Kiluan.">
    <meta name="keywords" content="katalog wisata, sewa perahu lampung, snorkeling pahawang, homestay krui, lumba-lumba kiluan">
    <meta name="author" content="PesisirConnect">

    <title>Katalog Wisata — PesisirConnect</title>

    {{-- Open Graph / Facebook --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="Katalog Wisata — PesisirConnect">
    <meta property="og:description" content="Katalog layanan wisata pesisir Lampung — sewa perahu, alat snorkeling, dan homestay di Pahawang, Krui, Teluk Kiluan.">
    <meta property="og:image" content="https://placehold.co/1200x630/0ea5e9/ffffff?text=Katalog+Wisata+PesisirConnect">

    {{-- Twitter --}}
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="Katalog Wisata — PesisirConnect">
    <meta property="twitter:description" content="Katalog layanan wisata pesisir Lampung — sewa perahu, alat snorkeling, dan homestay di Pahawang, Krui, Teluk Kiluan.">
    <meta property="twitter:image" content="https://placehold.co/1200x630/0ea5e9/ffffff?text=Katalog+Wisata+PesisirConnect">

    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect width='100' height='100' rx='20' fill='%230ea5e9'/><text x='50' y='75' font-size='70' font-family='sans-serif' font-weight='bold' fill='white' text-anchor='middle'>PC</text></svg>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">

    <style>
        [x-cloak] { display: none !important; }
        input[type="range"]::-webkit-slider-thumb {
            pointer-events: auto;
        }
        input[type="range"]::-moz-range-thumb {
            pointer-events: auto;
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased" x-data="{ showFilters: false }">

    {{-- Navbar --}}
    <x-navbar :always-scrolled="true" />

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

                        {{-- Search with Autocomplete --}}
                        <div x-data="searchAutocomplete()" @click.away="isOpen = false" class="relative">
                            <label class="block text-xs font-semibold text-gray-700 mb-2">Pencarian</label>
                            <input type="text" name="search" x-model="query" @input.debounce.300ms="fetchSuggestions"
                                   @focus="isOpen = true"
                                   placeholder="Cari layanan atau lokasi..."
                                   class="w-full rounded-xl border-gray-200 text-sm focus:border-ocean-400 focus:ring-ocean-400" autocomplete="off">
                            
                            {{-- Suggestions Dropdown --}}
                            <div x-show="isOpen && suggestions.length > 0" x-transition x-cloak
                                 class="absolute z-50 w-full mt-1 bg-white rounded-xl shadow-lg border border-gray-100 py-2 max-h-60 overflow-y-auto">
                                <template x-for="item in suggestions" :key="item.slug">
                                    <a :href="item.url" class="block px-4 py-2 hover:bg-ocean-50">
                                        <div class="font-medium text-sm text-gray-900" x-text="item.name"></div>
                                        <div class="text-xs text-gray-500 flex justify-between mt-1">
                                            <span x-text="item.location"></span>
                                            <span class="text-ocean-600 font-semibold" x-text="item.price"></span>
                                        </div>
                                    </a>
                                </template>
                            </div>
                        </div>

                        {{-- Category --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-2">Kategori</label>
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="kategori" value=""
                                           {{ !request('kategori') ? 'checked' : '' }}
                                           class="text-ocean-500 focus:ring-ocean-400 border-gray-300">
                                    <span class="text-sm text-gray-600">Semua Kategori</span>
                                </label>
                                @foreach($categories as $cat)
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="kategori" value="{{ $cat->slug }}"
                                               {{ request('kategori') === $cat->slug ? 'checked' : '' }}
                                               class="text-ocean-500 focus:ring-ocean-400 border-gray-300">
                                        <span class="text-sm text-gray-600">{{ $cat->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Location --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-2">Lokasi</label>
                            <select name="lokasi"
                                    class="w-full rounded-xl border-gray-200 text-sm focus:border-ocean-400 focus:ring-ocean-400">
                                <option value="">Semua Lokasi</option>
                                @foreach($locations as $loc)
                                    <option value="{{ $loc }}" {{ request('lokasi') === $loc ? 'selected' : '' }}>{{ $loc }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Price Range --}}
                        <div x-data="rangeSlider({{ $priceRange['min'] }}, {{ $priceRange['max'] }}, {{ request('harga_min', $priceRange['min']) }}, {{ request('harga_max', $priceRange['max']) }})" class="space-y-4">
                            <label class="block text-xs font-semibold text-gray-700 mb-1">Rentang Harga</label>
                            
                            <div class="relative h-2 rounded-full bg-gray-100 mt-6 mb-2">
                                <div class="absolute h-full rounded-full bg-ocean-500" 
                                     :style="`left: ${getPercent(minPrice)}%; right: ${100 - getPercent(maxPrice)}%`"></div>
                                     
                                <input type="range" min="{{ $priceRange['min'] }}" max="{{ $priceRange['max'] }}" step="10000" x-model.number="minPrice" @input="checkMin()"
                                       class="absolute pointer-events-none appearance-none z-20 h-2 w-full opacity-0 cursor-pointer">
                                <div class="absolute w-5 h-5 rounded-full bg-white border-2 border-ocean-500 shadow-md pointer-events-none -mt-1.5 z-30"
                                     :style="`left: calc(${getPercent(minPrice)}% - 10px)`"></div>
                                     
                                <input type="range" min="{{ $priceRange['min'] }}" max="{{ $priceRange['max'] }}" step="10000" x-model.number="maxPrice" @input="checkMax()"
                                       class="absolute pointer-events-none appearance-none z-20 h-2 w-full opacity-0 cursor-pointer">
                                <div class="absolute w-5 h-5 rounded-full bg-white border-2 border-ocean-500 shadow-md pointer-events-none -mt-1.5 z-30"
                                     :style="`left: calc(${getPercent(maxPrice)}% - 10px)`"></div>
                            </div>
                            
                            <div class="flex items-center gap-2 pt-2">
                                <div class="flex-1 relative">
                                    <span class="absolute left-2.5 top-2 text-xs text-gray-400">Rp</span>
                                    <input type="number" name="harga_min" x-model="minPrice"
                                           class="w-full pl-7 pr-2 py-1.5 rounded-xl border-gray-200 text-xs focus:border-ocean-400 focus:ring-ocean-400 font-medium text-gray-700">
                                </div>
                                <span class="text-gray-400 text-xs">-</span>
                                <div class="flex-1 relative">
                                    <span class="absolute left-2.5 top-2 text-xs text-gray-400">Rp</span>
                                    <input type="number" name="harga_max" x-model="maxPrice"
                                           class="w-full pl-7 pr-2 py-1.5 rounded-xl border-gray-200 text-xs focus:border-ocean-400 focus:ring-ocean-400 font-medium text-gray-700">
                                </div>
                            </div>
                        </div>

                        {{-- Rating --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-2">Minimal Rating</label>
                            <select name="rating_min" class="w-full rounded-xl border-gray-200 text-sm focus:border-ocean-400 focus:ring-ocean-400">
                                <option value="">Semua Rating</option>
                                <option value="4.5" {{ request('rating_min') == '4.5' ? 'selected' : '' }}>⭐ 4.5+</option>
                                <option value="4" {{ request('rating_min') == '4' ? 'selected' : '' }}>⭐ 4.0+</option>
                                <option value="3" {{ request('rating_min') == '3' ? 'selected' : '' }}>⭐ 3.0+</option>
                            </select>
                        </div>

                        {{-- Capacity --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-2">Kapasitas (Orang)</label>
                            <input type="number" name="kapasitas_min" value="{{ request('kapasitas_min') }}" min="1" placeholder="Min. kapasitas" class="w-full rounded-xl border-gray-200 text-sm focus:border-ocean-400 focus:ring-ocean-400">
                        </div>

                        {{-- Sort --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-2">Urutkan</label>
                            <select name="sort"
                                    class="w-full rounded-xl border-gray-200 text-sm focus:border-ocean-400 focus:ring-ocean-400">
                                <option value="" {{ !request('sort') ? 'selected' : '' }}>Terbaru</option>
                                <option value="popular" {{ request('sort') === 'popular' ? 'selected' : '' }}>Paling Populer</option>
                                <option value="price_low" {{ request('sort') === 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                                <option value="price_high" {{ request('sort') === 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                                <option value="rating" {{ request('sort') === 'rating' ? 'selected' : '' }}>Rating Tertinggi</option>
                            </select>
                        </div>

                        <button type="submit" class="btn-primary w-full !py-2.5">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            Terapkan Filter
                        </button>

                        @if(request()->hasAny(['search', 'kategori', 'lokasi', 'sort']))
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

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('searchAutocomplete', () => ({
                query: '{{ request('search') }}',
                suggestions: [],
                isOpen: false,
                async fetchSuggestions() {
                    if (this.query.length < 2) {
                        this.suggestions = [];
                        return;
                    }
                    try {
                        const res = await fetch(`/api/search/suggestions?q=${encodeURIComponent(this.query)}`);
                        this.suggestions = await res.json();
                        this.isOpen = this.suggestions.length > 0;
                    } catch (e) {
                        console.error('Search autocomplete failed', e);
                    }
                }
            }));

            Alpine.data('rangeSlider', (min, max, currentMin, currentMax) => ({
                minPrice: currentMin,
                maxPrice: currentMax,
                min: min,
                max: max,
                getPercent(val) {
                    return ((val - this.min) / (this.max - this.min)) * 100;
                },
                checkMin() {
                    if (this.minPrice > this.maxPrice - 10000) {
                        this.minPrice = this.maxPrice - 10000;
                    }
                },
                checkMax() {
                    if (this.maxPrice < this.minPrice + 10000) {
                        this.maxPrice = this.minPrice + 10000;
                    }
                },
                formatNumber(val) {
                    return new Intl.NumberFormat('id-ID').format(val);
                }
            }));
        })
    </script>
</body>
</html>
