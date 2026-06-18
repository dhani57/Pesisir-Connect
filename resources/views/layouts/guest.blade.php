<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="Masuk atau daftar ke PesisirConnect — Marketplace wisata pesisir Lampung.">

        <title>{{ $title ?? 'Autentikasi' }} — PesisirConnect</title>

        {{-- Favicon --}}
        <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect width='100' height='100' rx='20' fill='%230ea5e9'/><text x='50' y='75' font-size='70' font-family='sans-serif' font-weight='bold' fill='white' text-anchor='middle'>PC</text></svg>">

        {{-- Google Fonts — Plus Jakarta Sans --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">

        {{-- Alpine.js cloak --}}
        <style>[x-cloak] { display: none !important; }</style>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased">

        <div class="min-h-screen flex">

            {{-- LEFT — Gambar Pesisir (Hidden di Mobile) --}}
            <div class="hidden lg:flex lg:w-1/2 xl:w-[55%] relative overflow-hidden">
                {{-- Background Image --}}
                <img src="{{ asset('images/auth-bg.png') }}"
                     alt="Pesisir Lampung"
                     class="absolute inset-0 w-full h-full object-cover">

                {{-- Gradient Overlay --}}
                <div class="absolute inset-0 bg-gradient-to-br from-ocean-950/70 via-ocean-900/50 to-ocean-800/60"></div>

                {{-- Decorative Blobs --}}
                <div class="absolute top-20 left-10 w-72 h-72 bg-ocean-400/15 rounded-full blur-3xl animate-float"></div>
                <div class="absolute bottom-32 right-16 w-96 h-96 bg-coral-400/10 rounded-full blur-3xl animate-float" style="animation-delay: 3s"></div>

                {{-- Content over image --}}
                <div class="relative z-10 flex flex-col justify-between w-full p-10 xl:p-16">
                    {{-- Logo --}}
                    <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                        <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-ocean-400 to-ocean-600 flex items-center justify-center shadow-lg shadow-ocean-500/30 group-hover:shadow-xl transition-shadow duration-200">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <span class="text-2xl font-bold text-white">
                            Pesisir<span class="text-ocean-300">Connect</span>
                        </span>
                    </a>

                    {{-- Testimonial / Tagline --}}
                    <div class="mb-10">
                        <blockquote class="max-w-md">
                            <div class="flex gap-1 mb-4">
                                @for($i = 0; $i < 5; $i++)
                                    <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                            <p class="text-lg xl:text-xl text-white/90 font-medium leading-relaxed italic">
                                "Pengalaman terbaik kami di Pahawang! Booking lewat PesisirConnect sangat mudah dan nelayan lokal yang jadi guide sangat ramah."
                            </p>
                            <footer class="mt-5 flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-ocean-400 to-coral-400 flex items-center justify-center text-white text-sm font-bold">
                                    AR
                                </div>
                                <div>
                                    <p class="text-white font-semibold text-sm">Andi Rahmawan</p>
                                    <p class="text-white/50 text-xs">Wisatawan dari Jakarta</p>
                                </div>
                            </footer>
                        </blockquote>

                        {{-- Stats mini --}}
                        <div class="flex gap-8 mt-10 pt-8 border-t border-white/10">
                            <div>
                                <div class="text-2xl font-bold text-white">500+</div>
                                <div class="text-xs text-white/50 mt-0.5">Wisatawan Puas</div>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-white">4.8</div>
                                <div class="text-xs text-white/50 mt-0.5">Rating Rata-rata</div>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-white">50+</div>
                                <div class="text-xs text-white/50 mt-0.5">Layanan</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- RIGHT — Form Area --}}
            <div class="w-full lg:w-1/2 xl:w-[45%] flex flex-col">

                {{-- Mobile Header --}}
                <div class="lg:hidden px-6 pt-6">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-ocean-500 to-ocean-700 flex items-center justify-center shadow-md">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <span class="text-lg font-bold text-gray-900">
                            Pesisir<span class="text-ocean-500">Connect</span>
                        </span>
                    </a>
                </div>

                {{-- Form Content —  vertically centered --}}
                <div class="flex-1 flex items-center justify-center px-6 py-10 sm:px-10 lg:px-12 xl:px-16">
                    <div class="w-full max-w-md">
                        {{ $slot }}
                    </div>
                </div>

                {{-- Footer --}}
                <div class="px-6 pb-6 text-center">
                    <p class="text-xs text-gray-400">
                        &copy; {{ date('Y') }} PesisirConnect. All rights reserved.
                    </p>
                </div>
            </div>
        </div>

    </body>
</html>
