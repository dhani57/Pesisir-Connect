{{-- Hero Section — Landing Page --}}
@props(['locations' => collect()])

<section class="relative min-h-[100svh] flex items-center overflow-hidden" id="hero-section">

    {{-- Background Image --}}
    <div class="absolute inset-0">
        <img src="{{ asset('images/hero/hero-bg.png') }}"
             alt="Pesisir Lampung"
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-b from-ocean-950/60 via-ocean-900/40 to-ocean-950/70"></div>
    </div>

    {{-- Animated Decorations --}}
    <div class="absolute top-20 left-10 w-64 h-64 bg-ocean-400/10 rounded-full blur-3xl animate-float"></div>
    <div class="absolute bottom-20 right-10 w-96 h-96 bg-coral-400/10 rounded-full blur-3xl animate-float" style="animation-delay: 3s"></div>

    {{-- Content --}}
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full pt-24 pb-12 md:pt-32 md:pb-20">
        <div class="max-w-3xl">

            {{-- Badge --}}
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white/90 text-xs sm:text-sm font-medium mb-6 animate-fade-in">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                #1 Marketplace Wisata Pesisir Lampung
            </div>

            {{-- Heading --}}
            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-white leading-tight mb-4 md:mb-6 animate-slide-up">
                Jelajahi Keindahan
                <span class="block text-gradient-sunset">Pesisir Lampung</span>
            </h1>

            {{-- Subtitle --}}
            <p class="text-base sm:text-lg text-white/70 max-w-xl mb-8 md:mb-10 leading-relaxed animate-slide-up" style="animation-delay: 0.1s">
                Sewa perahu wisata, alat snorkeling, dan temukan homestay terbaik di Pahawang, Krui, dan Teluk Kiluan — langsung dari tangan lokal.
            </p>

            {{-- Search Bar --}}
            <div class="animate-slide-up" style="animation-delay: 0.2s"
                 x-data="{ search: '', location: '' }">
                <form action="{{ route('catalog') }}" method="GET"
                      class="relative bg-white rounded-2xl sm:rounded-full p-2 shadow-hero max-w-2xl">
                    <div class="flex flex-col sm:flex-row gap-2 sm:gap-0">
                        {{-- Search Input --}}
                        <div class="flex-1 flex items-center gap-3 px-4 py-2 sm:py-0">
                            <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            <input type="text"
                                   name="search"
                                   x-model="search"
                                   placeholder="Cari perahu, snorkeling, homestay..."
                                   class="w-full border-0 bg-transparent text-sm text-gray-700 placeholder-gray-400 focus:ring-0 focus:outline-none p-0"
                                   id="hero-search-input">
                        </div>

                        {{-- Location Select --}}
                        <div class="flex items-center gap-3 px-4 py-2 sm:py-0 sm:border-l border-gray-200">
                            <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <select name="location"
                                    x-model="location"
                                    class="w-full border-0 bg-transparent text-sm text-gray-700 focus:ring-0 focus:outline-none p-0 appearance-none cursor-pointer"
                                    id="hero-location-select">
                                <option value="">Semua Lokasi</option>
                                @foreach($locations as $loc)
                                    <option value="{{ $loc }}">{{ $loc }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Search Button --}}
                        <button type="submit"
                                class="btn-cta !rounded-xl sm:!rounded-full !px-6 !py-3 shrink-0"
                                id="hero-search-btn">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            <span class="sm:hidden lg:inline">Cari</span>
                        </button>
                    </div>
                </form>
            </div>

            {{-- Stats --}}
            <div class="flex flex-wrap gap-6 sm:gap-10 mt-10 animate-slide-up" style="animation-delay: 0.3s">
                <div>
                    <div class="text-2xl sm:text-3xl font-bold text-white">50+</div>
                    <div class="text-xs sm:text-sm text-white/50">Layanan Wisata</div>
                </div>
                <div>
                    <div class="text-2xl sm:text-3xl font-bold text-white">3</div>
                    <div class="text-xs sm:text-sm text-white/50">Destinasi Pesisir</div>
                </div>
                <div>
                    <div class="text-2xl sm:text-3xl font-bold text-white">500+</div>
                    <div class="text-xs sm:text-sm text-white/50">Wisatawan Puas</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Scroll Indicator --}}
    <div class="absolute bottom-6 left-1/2 -translate-x-1/2 animate-bounce hidden md:flex flex-col items-center gap-2">
        <span class="text-white/40 text-xs">Scroll ke bawah</span>
        <svg class="w-5 h-5 text-white/40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
    </div>
</section>
