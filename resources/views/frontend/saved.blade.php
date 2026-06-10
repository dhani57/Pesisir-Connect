<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Disimpan — PesisirConnect</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
</head>
<body class="antialiased bg-gray-50">

    <x-navbar :always-scrolled="true" />

    <main class="pt-24 pb-16 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-8">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Wisata Tersimpan</h1>
                <p class="text-sm text-gray-500 mt-1">Daftar layanan wisata yang Anda simpan untuk nanti</p>
            </div>

            @if($wishlists->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5 md:gap-6">
                    @foreach($wishlists as $wishlist)
                        <div class="relative">
                            <x-product-card :product="$wishlist->product" />
                            
                            {{-- Remove from wishlist button overlay --}}
                            <form action="{{ route('wishlist.toggle', $wishlist->product_id) }}" method="POST" class="absolute top-3 right-3 z-10">
                                @csrf
                                <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-full bg-white/90 backdrop-blur text-red-500 hover:bg-red-50 hover:text-red-600 transition-colors shadow-sm" title="Hapus dari simpanan">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/></svg>
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>

                <div class="mt-10">
                    {{ $wishlists->links() }}
                </div>
            @else
                <div class="text-center py-20 bg-white rounded-2xl shadow-sm border border-gray-100">
                    <div class="w-20 h-20 mx-auto mb-5 rounded-2xl bg-gray-50 flex items-center justify-center">
                        <svg class="w-10 h-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </div>
                    <h3 class="text-gray-900 font-bold text-lg mb-2">Belum ada yang disimpan</h3>
                    <p class="text-sm text-gray-500 max-w-sm mx-auto mb-6">Jelajahi katalog kami dan simpan destinasi impian Anda untuk mempermudah perencanaan liburan.</p>
                    <a href="{{ route('catalog') }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-ocean-600 text-white text-sm font-semibold rounded-xl hover:bg-ocean-700 transition-colors shadow-sm">
                        Jelajahi Katalog
                    </a>
                </div>
            @endif

        </div>
    </main>

    <x-footer />
</body>
</html>
