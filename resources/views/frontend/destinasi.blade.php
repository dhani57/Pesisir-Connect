<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Jelajahi destinasi wisata pesisir Lampung — Pulau Pahawang, Pantai Krui, dan Teluk Kiluan. Temukan keindahan alam yang menakjubkan.">
    <meta name="keywords" content="destinasi lampung, pahawang, krui, teluk kiluan, wisata pesisir, ekowisata lampung">

    <title>Destinasi Wisata — PesisirConnect</title>

    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🌊</text></svg>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">

    <style>[x-cloak] { display: none !important; }</style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">

    {{-- Navbar --}}
    <x-navbar />

    {{-- Hero Banner --}}
    <section class="relative pt-20 md:pt-24 pb-16 md:pb-20 overflow-hidden" id="destinasi-hero">
        {{-- Gradient Background --}}
        <div class="absolute inset-0 bg-gradient-to-br from-ocean-900 via-ocean-800 to-ocean-950"></div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-ocean-400/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-72 h-72 bg-coral-400/10 rounded-full blur-3xl"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-12 md:pt-16">
            <div class="text-center max-w-3xl mx-auto">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white/90 text-xs sm:text-sm font-medium mb-6 animate-fade-in">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    3 Destinasi Unggulan
                </div>
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white leading-tight mb-4 animate-slide-up">
                    Destinasi Wisata
                    <span class="block text-gradient-sunset">Pesisir Lampung</span>
                </h1>
                <p class="text-base sm:text-lg text-white/60 max-w-xl mx-auto animate-slide-up" style="animation-delay: 0.1s">
                    Temukan surga tersembunyi di pesisir Lampung — dari terumbu karang yang menakjubkan hingga ombak kelas dunia.
                </p>
            </div>
        </div>
    </section>

    {{-- Destinations Grid --}}
    <section class="py-12 md:py-20" id="destination-cards">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="space-y-16 md:space-y-24">
                @foreach($destinations as $index => $dest)
                    <div class="group" id="dest-{{ $dest['slug'] }}">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center {{ $index % 2 !== 0 ? 'lg:flex-row-reverse' : '' }}">
                            {{-- Image --}}
                            <div class="{{ $index % 2 !== 0 ? 'lg:order-2' : '' }}">
                                <div class="relative rounded-2xl lg:rounded-3xl overflow-hidden shadow-xl group-hover:shadow-2xl transition-shadow duration-500">
                                    <img src="{{ asset('images/' . $dest['image']) }}"
                                         alt="{{ $dest['name'] }}"
                                         class="w-full h-64 sm:h-80 lg:h-96 object-cover group-hover:scale-105 transition-transform duration-700">

                                    {{-- Rating Badge --}}
                                    <div class="absolute top-4 left-4 flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white/90 backdrop-blur-md shadow-lg">
                                        <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                        <span class="text-sm font-bold text-gray-800">{{ $dest['rating'] }}</span>
                                        <span class="text-xs text-gray-500">({{ $dest['reviews'] }})</span>
                                    </div>

                                    {{-- Location Badge --}}
                                    <div class="absolute bottom-4 left-4 flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-ocean-600/90 backdrop-blur-md text-white shadow-lg">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        <span class="text-xs font-medium">{{ $dest['location'] }}</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Content --}}
                            <div class="{{ $index % 2 !== 0 ? 'lg:order-1' : '' }}">
                                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-ocean-50 text-ocean-700 text-xs font-semibold mb-4">
                                    <span class="w-1.5 h-1.5 rounded-full bg-ocean-500"></span>
                                    {{ $dest['tagline'] }}
                                </div>

                                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                                    {{ $dest['name'] }}
                                </h2>

                                <p class="text-gray-600 leading-relaxed mb-6 text-sm sm:text-base">
                                    {{ $dest['description'] }}
                                </p>

                                {{-- Highlights --}}
                                <div class="grid grid-cols-2 gap-3 mb-8">
                                    @foreach($dest['highlights'] as $highlight)
                                        <div class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-gray-50 border border-gray-100">
                                            <div class="w-7 h-7 rounded-lg bg-ocean-100 flex items-center justify-center shrink-0">
                                                <svg class="w-3.5 h-3.5 text-ocean-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                            </div>
                                            <span class="text-xs sm:text-sm font-medium text-gray-700">{{ $highlight }}</span>
                                        </div>
                                    @endforeach
                                </div>

                                {{-- CTA --}}
                                <div class="flex flex-col sm:flex-row gap-3">
                                    <a href="{{ route('catalog', ['location' => $dest['name'] === 'Pantai Krui' ? 'Krui' : ($dest['name'] === 'Teluk Kiluan' ? 'Teluk Kiluan' : 'Pahawang')]) }}"
                                       class="btn-primary !py-3">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                        Lihat Layanan
                                    </a>
                                    <a href="{{ route('catalog') }}"
                                       class="btn-outline !py-3">
                                        Jelajahi Semua
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Map / CTA Section --}}
    <section class="py-16 md:py-24 bg-gradient-to-br from-ocean-900 via-ocean-800 to-ocean-950 relative overflow-hidden" id="destinasi-cta">
        <div class="absolute top-0 right-0 w-96 h-96 bg-ocean-400/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-72 h-72 bg-coral-400/10 rounded-full blur-3xl"></div>

        <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="w-16 h-16 mx-auto mb-6 rounded-2xl bg-white/10 backdrop-blur-md flex items-center justify-center">
                <svg class="w-8 h-8 text-ocean-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498l4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 00-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0z"/>
                </svg>
            </div>
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white mb-4">
                Siap Memulai Petualangan?
            </h2>
            <p class="text-white/60 max-w-2xl mx-auto mb-8 text-sm sm:text-base">
                Pilih destinasi favoritmu dan temukan layanan wisata terbaik — mulai dari sewa perahu, alat snorkeling, hingga homestay nyaman dengan harga terjangkau.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('catalog') }}" class="btn-cta !py-3.5 !px-8">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    Mulai Jelajahi Katalog
                </a>
                <a href="{{ route('register') }}" class="btn-outline !border-white/30 !text-white hover:!bg-white/10 !py-3.5 !px-8">
                    Daftar Gratis
                </a>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <x-footer />

</body>
</html>
