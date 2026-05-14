{{-- CTA Section — Landing Page --}}

<section class="py-16 md:py-24 relative overflow-hidden" id="cta-section">
    {{-- Background --}}
    <div class="absolute inset-0 bg-gradient-to-br from-ocean-600 via-ocean-700 to-ocean-900"></div>
    <div class="absolute inset-0 opacity-10">
        <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
            <defs>
                <pattern id="wave-pattern" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                    <path d="M0 10 Q5 0, 10 10 Q15 20, 20 10" fill="none" stroke="white" stroke-width="0.5"/>
                </pattern>
            </defs>
            <rect width="100" height="100" fill="url(#wave-pattern)"/>
        </svg>
    </div>

    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white mb-4 leading-tight">
            Siap Menjelajahi Pesisir Lampung?
        </h2>
        <p class="text-base sm:text-lg text-ocean-100 max-w-2xl mx-auto mb-8 leading-relaxed">
            Mulai petualanganmu sekarang. Temukan perahu wisata, alat snorkeling, dan homestay terbaik dengan harga terjangkau.
        </p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="{{ route('catalog') }}"
               class="btn-cta !py-3.5 !px-8 !text-base w-full sm:w-auto"
               id="cta-explore">
                Jelajahi Sekarang
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
            @guest
                <a href="{{ route('register') }}"
                   class="inline-flex items-center justify-center gap-2 rounded-xl border-2 border-white/30 bg-white/10 backdrop-blur-sm px-8 py-3.5 text-base font-semibold text-white hover:bg-white/20 active:scale-[0.98] transition-all duration-200 w-full sm:w-auto"
                   id="cta-register">
                    Daftar Sebagai Vendor
                </a>
            @endguest
        </div>
    </div>
</section>
