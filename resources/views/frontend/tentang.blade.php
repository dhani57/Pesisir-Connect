<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    {{-- SEO Meta Tags --}}
    <meta name="description" content="Tentang PesisirConnect — Misi kami dalam memberdayakan masyarakat pesisir Lampung melalui ekowisata berkelanjutan dan marketplace pariwisata digital.">
    <meta name="keywords" content="tentang pesisirconnect, ekowisata lampung, pemberdayaan masyarakat pesisir, pariwisata berkelanjutan">
    <meta name="author" content="PesisirConnect">

    <title>Tentang Kami — PesisirConnect</title>

    {{-- Open Graph / Facebook --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="Tentang Kami — PesisirConnect">
    <meta property="og:description" content="Tentang PesisirConnect — Misi kami dalam memberdayakan masyarakat pesisir Lampung melalui ekowisata berkelanjutan dan marketplace pariwisata digital.">
    <meta property="og:image" content="https://placehold.co/1200x630/0ea5e9/ffffff?text=Tentang+PesisirConnect">

    {{-- Twitter --}}
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="Tentang Kami — PesisirConnect">
    <meta property="twitter:description" content="Tentang PesisirConnect — Misi kami dalam memberdayakan masyarakat pesisir Lampung melalui ekowisata berkelanjutan dan marketplace pariwisata digital.">
    <meta property="twitter:image" content="https://placehold.co/1200x630/0ea5e9/ffffff?text=Tentang+PesisirConnect">

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
    <section class="relative pt-20 md:pt-24 pb-16 md:pb-20 overflow-hidden" id="tentang-hero">
        <div class="absolute inset-0 bg-gradient-to-br from-ocean-900 via-ocean-800 to-ocean-950"></div>
        <div class="absolute top-10 left-1/4 w-96 h-96 bg-ocean-400/10 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-10 right-1/4 w-72 h-72 bg-coral-400/10 rounded-full blur-3xl animate-float" style="animation-delay: 3s"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-12 md:pt-16">
            <div class="text-center max-w-3xl mx-auto">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white/90 text-xs sm:text-sm font-medium mb-6 animate-fade-in">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342"/></svg>
                    Misi & Visi Kami
                </div>
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white leading-tight mb-4 animate-slide-up">
                    Tentang
                    <span class="text-gradient-sunset">PesisirConnect</span>
                </h1>
                <p class="text-base sm:text-lg text-white/60 max-w-xl mx-auto animate-slide-up" style="animation-delay: 0.1s">
                    Menghubungkan wisatawan dengan keindahan alam pesisir Lampung sambil memberdayakan masyarakat lokal.
                </p>
            </div>
        </div>
    </section>

    {{-- Mission Section --}}
    <section class="py-16 md:py-24" id="misi-section">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                {{-- Left: Content --}}
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-ocean-50 text-ocean-700 text-xs font-semibold mb-5">
                        <span class="w-1.5 h-1.5 rounded-full bg-ocean-500"></span>
                        Misi Kami
                    </div>

                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-6">
                        Memberdayakan Masyarakat Pesisir Melalui <span class="text-gradient-ocean">Ekowisata Digital</span>
                    </h2>

                    <div class="space-y-4 text-gray-600 text-sm sm:text-base leading-relaxed">
                        <p>
                            <strong class="text-gray-800">PesisirConnect</strong> lahir dari keprihatinan terhadap potensi wisata pesisir Lampung yang belum terkelola secara optimal. Banyak nelayan dan masyarakat lokal memiliki layanan wisata berkualitas — dari sewa perahu, penyediaan alat snorkeling, hingga homestay nyaman — namun sulit dijangkau oleh wisatawan.
                        </p>
                        <p>
                            Kami hadir sebagai <strong class="text-gray-800">jembatan digital</strong> yang menghubungkan wisatawan dengan penyedia layanan lokal secara langsung, tanpa perantara. Dengan cara ini, kami memastikan bahwa setiap rupiah yang dibelanjakan wisatawan memberikan dampak langsung bagi kesejahteraan masyarakat pesisir.
                        </p>
                        <p>
                            Platform kami juga mendorong praktik <strong class="text-gray-800">ekowisata berkelanjutan</strong> — memastikan keindahan terumbu karang, pantai, dan ekosistem laut tetap terjaga untuk generasi mendatang.
                        </p>
                    </div>
                </div>

                {{-- Right: Values Grid --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                    {{-- Value 1 --}}
                    <div class="bg-white rounded-2xl p-6 shadow-card hover:shadow-card-hover transition-all duration-300 group hover:-translate-y-1">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-ocean-100 to-ocean-200 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6 text-ocean-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-gray-900 mb-2">Pemberdayaan Lokal</h3>
                        <p class="text-xs sm:text-sm text-gray-500 leading-relaxed">Memaksimalkan pendapatan langsung bagi nelayan dan masyarakat pesisir tanpa perantara berlebih.</p>
                    </div>

                    {{-- Value 2 --}}
                    <div class="bg-white rounded-2xl p-6 shadow-card hover:shadow-card-hover transition-all duration-300 group hover:-translate-y-1">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-100 to-emerald-200 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418"/>
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-gray-900 mb-2">Ekowisata Berkelanjutan</h3>
                        <p class="text-xs sm:text-sm text-gray-500 leading-relaxed">Mempromosikan wisata yang ramah lingkungan dan menjaga ekosistem laut pesisir Lampung.</p>
                    </div>

                    {{-- Value 3 --}}
                    <div class="bg-white rounded-2xl p-6 shadow-card hover:shadow-card-hover transition-all duration-300 group hover:-translate-y-1">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-100 to-amber-200 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-gray-900 mb-2">Transparan & Terpercaya</h3>
                        <p class="text-xs sm:text-sm text-gray-500 leading-relaxed">Harga jelas, ulasan nyata, dan booking langsung dengan penyedia layanan terverifikasi.</p>
                    </div>

                    {{-- Value 4 --}}
                    <div class="bg-white rounded-2xl p-6 shadow-card hover:shadow-card-hover transition-all duration-300 group hover:-translate-y-1">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-coral-100 to-coral-200 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6 text-coral-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                            </svg>
                        </div>
                        <h3 class="text-base font-bold text-gray-900 mb-2">Cinta Pesisir</h3>
                        <p class="text-xs sm:text-sm text-gray-500 leading-relaxed">Setiap transaksi berkontribusi pada konservasi pantai dan peningkatan taraf hidup masyarakat lokal.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Stats Section --}}
    <section class="py-16 md:py-20 bg-gradient-to-r from-ocean-50 via-white to-ocean-50" id="stats-section">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="section-title">PesisirConnect dalam Angka</h2>
                <p class="section-subtitle mx-auto">Dampak nyata yang telah kami ciptakan bersama masyarakat pesisir Lampung.</p>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                @foreach($stats as $stat)
                    <div class="bg-white rounded-2xl p-6 sm:p-8 text-center shadow-card hover:shadow-card-hover transition-all duration-300 hover:-translate-y-1 group">
                        <div class="w-14 h-14 mx-auto rounded-xl bg-gradient-to-br from-ocean-500 to-ocean-600 flex items-center justify-center mb-4 shadow-md shadow-ocean-500/25 group-hover:scale-110 transition-transform duration-300">
                            @if($stat['icon'] === 'compass')
                                <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418"/></svg>
                            @elseif($stat['icon'] === 'map-pin')
                                <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                            @elseif($stat['icon'] === 'users')
                                <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
                            @elseif($stat['icon'] === 'handshake')
                                <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10.05 4.575a1.575 1.575 0 10-3.15 0v3.026a2.999 2.999 0 00-1.9 2.798v1.926a3 3 0 001.9 2.798v1.302a1.575 1.575 0 003.15 0M13.95 4.575a1.575 1.575 0 113.15 0v3.026a2.999 2.999 0 011.9 2.798v1.926a3 3 0 01-1.9 2.798v1.302a1.575 1.575 0 01-3.15 0"/></svg>
                            @endif
                        </div>
                        <div class="text-3xl sm:text-4xl font-bold text-gray-900 mb-1">{{ $stat['value'] }}</div>
                        <div class="text-xs sm:text-sm text-gray-500 font-medium">{{ $stat['label'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- How It Works --}}
    <section class="py-16 md:py-24" id="cara-kerja">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 md:mb-16">
                <h2 class="section-title">Bagaimana PesisirConnect Bekerja?</h2>
                <p class="section-subtitle mx-auto">Tiga langkah mudah untuk memulai petualangan pesisirmu.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-6 lg:gap-10">
                {{-- Step 1 --}}
                <div class="relative text-center group">
                    <div class="w-16 h-16 mx-auto mb-6 rounded-2xl bg-gradient-to-br from-ocean-500 to-ocean-600 flex items-center justify-center shadow-lg shadow-ocean-500/25 group-hover:scale-110 transition-transform duration-300">
                        <span class="text-xl font-bold text-white">1</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-3">Pilih Destinasi</h3>
                    <p class="text-sm text-gray-500 leading-relaxed max-w-xs mx-auto">
                        Jelajahi destinasi pesisir Lampung — Pahawang, Krui, atau Teluk Kiluan — dan temukan layanan yang sesuai keinginanmu.
                    </p>
                    {{-- Connector line (hidden on mobile) --}}
                    <div class="hidden md:block absolute top-8 left-[60%] w-[80%] border-t-2 border-dashed border-ocean-200"></div>
                </div>

                {{-- Step 2 --}}
                <div class="relative text-center group">
                    <div class="w-16 h-16 mx-auto mb-6 rounded-2xl bg-gradient-to-br from-ocean-500 to-ocean-600 flex items-center justify-center shadow-lg shadow-ocean-500/25 group-hover:scale-110 transition-transform duration-300">
                        <span class="text-xl font-bold text-white">2</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-3">Booking Langsung</h3>
                    <p class="text-sm text-gray-500 leading-relaxed max-w-xs mx-auto">
                        Pesan langsung dari penyedia layanan lokal — nelayan, guide, atau pemilik homestay — dengan harga transparan tanpa markup.
                    </p>
                    <div class="hidden md:block absolute top-8 left-[60%] w-[80%] border-t-2 border-dashed border-ocean-200"></div>
                </div>

                {{-- Step 3 --}}
                <div class="text-center group">
                    <div class="w-16 h-16 mx-auto mb-6 rounded-2xl bg-gradient-to-br from-coral-500 to-coral-600 flex items-center justify-center shadow-lg shadow-coral-500/25 group-hover:scale-110 transition-transform duration-300">
                        <span class="text-xl font-bold text-white">3</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-3">Nikmati & Bagikan</h3>
                    <p class="text-sm text-gray-500 leading-relaxed max-w-xs mx-auto">
                        Nikmati pengalaman wisata autentik dan bagikan ceritamu. Setiap kunjunganmu mendukung ekonomi masyarakat pesisir!
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Team / Pillars --}}
    <section class="py-16 md:py-20 bg-gradient-to-br from-ocean-900 via-ocean-800 to-ocean-950 relative overflow-hidden" id="tim-section">
        <div class="absolute top-0 right-0 w-96 h-96 bg-ocean-400/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-72 h-72 bg-coral-400/10 rounded-full blur-3xl"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-2xl sm:text-3xl font-bold text-white mb-3">Pilar Tim Kami</h2>
                <p class="text-sm sm:text-base text-white/50 max-w-xl mx-auto">
                    Tiga pilar utama yang menggerakkan PesisirConnect menuju visi pariwisata pesisir yang inklusif.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($team as $member)
                    <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-8 text-center hover:bg-white/10 transition-all duration-300 group hover:-translate-y-1">
                        <div class="w-16 h-16 mx-auto mb-5 rounded-2xl bg-gradient-to-br from-ocean-400/20 to-ocean-500/20 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            @if($member['icon'] === 'code')
                                <svg class="w-8 h-8 text-ocean-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3l-4.5 16.5"/></svg>
                            @elseif($member['icon'] === 'heart')
                                <svg class="w-8 h-8 text-coral-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/></svg>
                            @elseif($member['icon'] === 'globe')
                                <svg class="w-8 h-8 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418"/></svg>
                            @endif
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2">{{ $member['name'] }}</h3>
                        <p class="text-sm text-white/50">{{ $member['role'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Final CTA --}}
    <section class="py-16 md:py-24" id="tentang-cta">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="bg-gradient-to-br from-ocean-50 to-ocean-100/50 rounded-3xl p-8 sm:p-12 md:p-16 border border-ocean-100">
                <div class="w-16 h-16 mx-auto mb-6 rounded-2xl bg-gradient-to-br from-ocean-500 to-ocean-600 flex items-center justify-center shadow-lg shadow-ocean-500/25">
                    <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.59 14.37a6 6 0 01-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 006.16-12.12A14.98 14.98 0 009.631 8.41m5.96 5.96a14.926 14.926 0 01-5.841 2.58m-.119-8.54a6 6 0 00-7.381 5.84h4.8m2.581-5.84a14.927 14.927 0 00-2.58 5.84m2.699 2.7c-.103.021-.207.041-.311.06a15.09 15.09 0 01-2.448-2.448 14.9 14.9 0 01.06-.312m-2.24 2.39a4.493 4.493 0 00-1.757 4.306 4.493 4.493 0 004.306-1.758M16.5 9a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                    </svg>
                </div>
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4">
                    Bergabunglah dengan Misi Kami
                </h2>
                <p class="text-sm sm:text-base text-gray-600 max-w-2xl mx-auto mb-8 leading-relaxed">
                    Baik sebagai wisatawan yang ingin pengalaman autentik, atau sebagai nelayan & penyedia layanan yang ingin menjangkau lebih banyak pelanggan — PesisirConnect terbuka untuk Anda.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('register') }}" class="btn-primary !py-3.5 !px-8">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z"/></svg>
                        Daftar Sebagai Wisatawan
                    </a>
                    <a href="{{ auth()->check() ? route('catalog') : route('login') }}" class="btn-outline !py-3.5 !px-8">
                        Jelajahi Katalog
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <x-footer />

</body>
</html>
