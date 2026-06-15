{{-- ─────────────────────────────────────────────────────
    Navbar Component — PesisirConnect
    Mobile-first responsive navigation with Alpine.js
───────────────────────────────────────────────────── --}}

@props(['alwaysScrolled' => false])

<nav x-data="{ open: false, scrolled: @js($alwaysScrolled) }"
     x-init="if(!@js($alwaysScrolled)) { window.addEventListener('scroll', () => scrolled = window.scrollY > 50); scrolled = window.scrollY > 50; }"
     :class="scrolled ? 'bg-white/95 backdrop-blur-xl shadow-md' : 'bg-transparent'"
     class="fixed top-0 inset-x-0 z-50 transition-all duration-300"
     id="main-navbar">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 md:h-20">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2 group" id="navbar-logo">
                <div class="w-9 h-9 md:w-10 md:h-10 rounded-xl bg-gradient-to-br from-ocean-500 to-ocean-700 flex items-center justify-center shadow-md shadow-ocean-500/30 group-hover:shadow-lg transition-shadow duration-200">
                    <svg class="w-5 h-5 md:w-6 md:h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <span class="text-lg md:text-xl font-bold transition-colors duration-300"
                          :class="scrolled ? 'text-gray-900' : 'text-white'">
                        Pesisir<span class="text-ocean-500">Connect</span>
                    </span>
                </div>
            </a>

            {{-- Desktop Navigation --}}
            <div class="hidden md:flex items-center gap-1">
                @guest
                    <a href="{{ route('home') }}"
                       :class="scrolled ? '{{ request()->routeIs('home') ? 'text-ocean-600 bg-ocean-50' : 'text-gray-700 hover:text-ocean-600' }}' : '{{ request()->routeIs('home') ? 'text-white font-bold' : 'text-white/90 hover:text-white' }}'"
                       class="px-4 py-2 rounded-xl text-sm font-medium transition-colors duration-200">
                        Beranda
                    </a>
                    <a href="{{ route('destinasi') }}"
                       :class="scrolled ? '{{ request()->routeIs('destinasi') ? 'text-ocean-600 bg-ocean-50' : 'text-gray-700 hover:text-ocean-600' }}' : '{{ request()->routeIs('destinasi') ? 'text-white font-bold' : 'text-white/90 hover:text-white' }}'"
                       class="px-4 py-2 rounded-xl text-sm font-medium transition-colors duration-200">
                        Destinasi
                    </a>
                    <a href="{{ route('tentang') }}"
                       :class="scrolled ? '{{ request()->routeIs('tentang') ? 'text-ocean-600 bg-ocean-50' : 'text-gray-700 hover:text-ocean-600' }}' : '{{ request()->routeIs('tentang') ? 'text-white font-bold' : 'text-white/90 hover:text-white' }}'"
                       class="px-4 py-2 rounded-xl text-sm font-medium transition-colors duration-200">
                        Tentang
                    </a>
                @else
                    <a href="{{ route('dashboard') }}"
                       :class="scrolled ? '{{ request()->routeIs('dashboard') ? 'text-ocean-600 bg-ocean-50' : 'text-gray-700 hover:text-ocean-600' }}' : '{{ request()->routeIs('dashboard') ? 'text-white font-bold' : 'text-white/90 hover:text-white' }}'"
                       class="px-4 py-2 rounded-xl text-sm font-medium transition-colors duration-200">
                        Dashboard
                    </a>
                    <a href="{{ route('catalog') }}"
                       :class="scrolled ? '{{ request()->routeIs('catalog') ? 'text-ocean-600 bg-ocean-50' : 'text-gray-700 hover:text-ocean-600' }}' : '{{ request()->routeIs('catalog') ? 'text-white font-bold' : 'text-white/90 hover:text-white' }}'"
                       class="px-4 py-2 rounded-xl text-sm font-medium transition-colors duration-200">
                        Katalog
                    </a>
                    <a href="{{ route('destinasi') }}"
                       :class="scrolled ? '{{ request()->routeIs('destinasi') ? 'text-ocean-600 bg-ocean-50' : 'text-gray-700 hover:text-ocean-600' }}' : '{{ request()->routeIs('destinasi') ? 'text-white font-bold' : 'text-white/90 hover:text-white' }}'"
                       class="px-4 py-2 rounded-xl text-sm font-medium transition-colors duration-200">
                        Destinasi
                    </a>
                    <a href="{{ route('wishlist.index') }}"
                       :class="scrolled ? '{{ request()->routeIs('wishlist.index') ? 'text-ocean-600 bg-ocean-50' : 'text-gray-700 hover:text-ocean-600' }}' : '{{ request()->routeIs('wishlist.index') ? 'text-white font-bold' : 'text-white/90 hover:text-white' }}'"
                       class="px-4 py-2 rounded-xl text-sm font-medium transition-colors duration-200">
                        Simpan
                    </a>
                    @if(auth()->user()->isVendor() && auth()->user()->vendor)
                        <a href="{{ route('vendor.dashboard') }}"
                           :class="scrolled ? '{{ request()->routeIs('vendor.*') ? 'text-ocean-600 bg-ocean-50' : 'text-gray-700 hover:text-ocean-600' }}' : '{{ request()->routeIs('vendor.*') ? 'text-white font-bold' : 'text-white/90 hover:text-white' }}'"
                           class="px-4 py-2 rounded-xl text-sm font-medium transition-colors duration-200">
                            🏪 Vendor Panel
                        </a>
                    @elseif(!auth()->user()->isVendor())
                        <a href="{{ route('vendor.register') }}"
                           :class="scrolled ? 'text-gray-700 hover:text-ocean-600' : 'text-white/90 hover:text-white'"
                           class="px-4 py-2 rounded-xl text-sm font-medium transition-colors duration-200">
                            🚀 Jadi Vendor
                        </a>
                    @endif
                @endguest
            </div>

            {{-- Desktop Auth Buttons --}}
            <div class="hidden md:flex items-center gap-3">
                @guest
                    <a href="{{ route('login') }}"
                       :class="scrolled ? 'text-gray-700 hover:text-ocean-600' : 'text-white/90 hover:text-white'"
                       class="px-4 py-2 rounded-xl text-sm font-medium transition-colors duration-200"
                       id="nav-login">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}"
                       class="btn-primary !py-2.5 !px-5 !text-xs"
                       id="nav-register">
                        Daftar Gratis
                    </a>
                @else
                    <div x-data="{ profileOpen: false }" class="relative">
                        <button @click="profileOpen = !profileOpen"
                                :class="scrolled ? 'text-gray-700' : 'text-white'"
                                class="flex items-center gap-2 px-3 py-2 rounded-xl hover:bg-white/10 transition-colors duration-200"
                                id="nav-profile-btn">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-ocean-400 to-ocean-600 flex items-center justify-center text-white text-xs font-bold shadow-sm">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span class="text-sm font-medium">{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>

                        <div x-show="profileOpen"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             @click.away="profileOpen = false"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg ring-1 ring-black/5 py-2 animate-slide-down"
                             id="nav-profile-dropdown">
                            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-ocean-50 hover:text-ocean-600 transition-colors">Dashboard</a>
                            <a href="{{ route('chat.inbox') }}" class="flex items-center justify-between px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-ocean-600 transition-colors">
                                Pesan
                                @if(auth()->user()->unread_messages_count > 0)
                                    <span class="w-5 h-5 flex items-center justify-center bg-coral-500 text-white text-[10px] font-bold rounded-full">{{ auth()->user()->unread_messages_count }}</span>
                                @endif
                            </a>
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-ocean-50 hover:text-ocean-600 transition-colors">Profil Saya</a>
                            @if(auth()->user()->isVendor() && auth()->user()->vendor)
                                <a href="{{ route('vendor.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-ocean-50 hover:text-ocean-600 transition-colors">🏪 Vendor Dashboard</a>
                            @elseif(!auth()->user()->isVendor())
                                <a href="{{ route('vendor.register') }}" class="block px-4 py-2 text-sm text-ocean-600 hover:bg-ocean-50 transition-colors font-medium">🚀 Jadi Vendor</a>
                            @endif
                            <hr class="my-1 border-gray-100">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">Keluar</button>
                            </form>
                        </div>
                    </div>
                @endguest
            </div>

            {{-- Mobile Hamburger --}}
            <button @click="open = !open"
                    :class="scrolled ? 'text-gray-700' : 'text-white'"
                    class="md:hidden p-2 rounded-xl hover:bg-white/10 transition-colors duration-200"
                    id="mobile-menu-btn">
                <svg x-show="!open" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                <svg x-show="open" x-cloak class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         x-cloak
         class="md:hidden bg-white/95 backdrop-blur-xl border-t border-gray-100 shadow-lg"
         id="mobile-menu">
        <div class="px-4 py-4 space-y-1">
            @guest
                <a href="{{ route('home') }}" class="block px-4 py-3 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('home') ? 'text-ocean-600 bg-ocean-50' : 'text-gray-700 hover:bg-ocean-50 hover:text-ocean-600' }}">Beranda</a>
                <a href="{{ route('destinasi') }}" class="block px-4 py-3 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('destinasi') ? 'text-ocean-600 bg-ocean-50' : 'text-gray-700 hover:bg-ocean-50 hover:text-ocean-600' }}">Destinasi</a>
                <a href="{{ route('tentang') }}" class="block px-4 py-3 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('tentang') ? 'text-ocean-600 bg-ocean-50' : 'text-gray-700 hover:bg-ocean-50 hover:text-ocean-600' }}">Tentang</a>
                
                <hr class="my-3 border-gray-100">
                <div class="flex gap-3 pt-2">
                    <a href="{{ route('login') }}" class="btn-outline flex-1 !py-2.5 text-center">Masuk</a>
                    <a href="{{ route('register') }}" class="btn-primary flex-1 !py-2.5 text-center">Daftar</a>
                </div>
            @else
                <a href="{{ route('dashboard') }}" class="block px-4 py-3 rounded-xl text-sm font-medium text-gray-700 hover:bg-ocean-50 hover:text-ocean-600 transition-colors">Dashboard</a>
                <a href="{{ route('catalog') }}" class="block px-4 py-3 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('catalog') ? 'text-ocean-600 bg-ocean-50' : 'text-gray-700 hover:bg-ocean-50 hover:text-ocean-600' }}">Katalog</a>
                <a href="{{ route('destinasi') }}" class="block px-4 py-3 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('destinasi') ? 'text-ocean-600 bg-ocean-50' : 'text-gray-700 hover:bg-ocean-50 hover:text-ocean-600' }}">Destinasi</a>
                <a href="{{ route('wishlist.index') }}" class="block px-4 py-3 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('wishlist.index') ? 'text-ocean-600 bg-ocean-50' : 'text-gray-700 hover:bg-ocean-50 hover:text-ocean-600' }}">
                    Simpan
                </a>
                @if(auth()->user()->isVendor() && auth()->user()->vendor)
                    <a href="{{ route('vendor.dashboard') }}" class="block px-4 py-3 rounded-xl text-sm font-medium transition-colors text-ocean-600 hover:bg-ocean-50">🏪 Vendor Panel</a>
                @elseif(!auth()->user()->isVendor())
                    <a href="{{ route('vendor.register') }}" class="block px-4 py-3 rounded-xl text-sm font-medium transition-colors text-ocean-600 hover:bg-ocean-50">🚀 Jadi Vendor</a>
                @endif
                
                <hr class="my-3 border-gray-100">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-3 rounded-xl text-sm font-medium text-red-600 hover:bg-red-50 transition-colors">Keluar</button>
                </form>
            @endguest
        </div>
    </div>
</nav>
