<footer class="bg-gray-900 text-gray-300" id="footer">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="py-12 md:py-16 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
            {{-- Brand --}}
            <div class="sm:col-span-2 lg:col-span-1">
                <a href="{{ route('home') }}" class="flex items-center gap-2 mb-4">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-ocean-500 to-ocean-700 flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <span class="text-xl font-bold text-white">Pesisir<span class="text-ocean-400">Connect</span></span>
                </a>
                <p class="text-sm text-gray-400 leading-relaxed max-w-xs">Platform marketplace pariwisata pesisir Lampung. Hubungkan dirimu dengan keindahan laut.</p>
                <div class="flex gap-3 mt-5">
                    <a href="{{ setting('social_facebook', '#') }}" class="w-9 h-9 rounded-lg bg-white/5 hover:bg-ocean-500/20 flex items-center justify-center text-gray-400 hover:text-ocean-400 transition-all duration-200" aria-label="Facebook">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <a href="{{ setting('social_instagram', '#') }}" class="w-9 h-9 rounded-lg bg-white/5 hover:bg-ocean-500/20 flex items-center justify-center text-gray-400 hover:text-ocean-400 transition-all duration-200" aria-label="Instagram">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                    </a>
                </div>
            </div>
            {{-- Quick Links --}}
            <div>
                <h4 class="text-white font-semibold text-sm mb-4">Jelajahi</h4>
                <ul class="space-y-2.5">
                    <li><a href="{{ route('catalog') }}" class="text-sm text-gray-400 hover:text-ocean-400 transition-colors">Semua Produk</a></li>
                    <li><a href="{{ route('catalog', ['category' => 'sewa-perahu-wisata']) }}" class="text-sm text-gray-400 hover:text-ocean-400 transition-colors">Sewa Perahu</a></li>
                    <li><a href="{{ route('catalog', ['category' => 'alat-snorkeling']) }}" class="text-sm text-gray-400 hover:text-ocean-400 transition-colors">Alat Snorkeling</a></li>
                    <li><a href="{{ route('catalog', ['category' => 'homestay']) }}" class="text-sm text-gray-400 hover:text-ocean-400 transition-colors">Homestay</a></li>
                </ul>
            </div>
            {{-- Destinasi --}}
            <div>
                <h4 class="text-white font-semibold text-sm mb-4">Destinasi</h4>
                <ul class="space-y-2.5">
                    <li><a href="{{ route('catalog', ['location' => 'Pahawang']) }}" class="text-sm text-gray-400 hover:text-ocean-400 transition-colors">Pulau Pahawang</a></li>
                    <li><a href="{{ route('catalog', ['location' => 'Krui']) }}" class="text-sm text-gray-400 hover:text-ocean-400 transition-colors">Krui</a></li>
                    <li><a href="{{ route('catalog', ['location' => 'Teluk Kiluan']) }}" class="text-sm text-gray-400 hover:text-ocean-400 transition-colors">Teluk Kiluan</a></li>
                </ul>
            </div>
            {{-- Bantuan --}}
            <div>
                <h4 class="text-white font-semibold text-sm mb-4">Bantuan</h4>
                <ul class="space-y-2.5">
                    <li><a href="#" class="text-sm text-gray-400 hover:text-ocean-400 transition-colors">Cara Memesan</a></li>
                    <li><a href="#" class="text-sm text-gray-400 hover:text-ocean-400 transition-colors">FAQ</a></li>
                    <li><a href="#" class="text-sm text-gray-400 hover:text-ocean-400 transition-colors">Kebijakan Privasi</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-800 py-6 flex flex-col md:flex-row items-center justify-between gap-4">
            <p class="text-xs text-gray-500">&copy; {{ date('Y') }} PesisirConnect. All rights reserved.</p>
            <p class="text-xs text-gray-500">Made with ❤️ in Lampung, Indonesia</p>
        </div>
    </div>
</footer>
