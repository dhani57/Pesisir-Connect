{{-- Featured Products Section — Landing Page --}}
@props(['products'])

<section class="py-16 md:py-24 bg-white" id="rekomendasi">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Section Header --}}
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-10 md:mb-14">
            <div>
                <span class="badge-coral mb-3 inline-flex">Rekomendasi</span>
                <h2 class="section-title">Layanan Wisata Terpopuler</h2>
                <p class="section-subtitle">Pilihan terbaik dari para wisatawan sebelumnya</p>
            </div>
            <a href="{{ route('catalog') }}"
               class="btn-outline self-start sm:self-auto !py-2.5 !px-5 !text-xs shrink-0"
               id="view-all-products">
                Lihat Semua
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>

        {{-- Products Grid --}}
        @if($products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5 md:gap-6">
                @foreach($products as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        @else
            <div class="text-center py-16">
                <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gray-100 flex items-center justify-center">
                    <svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
                <h3 class="text-gray-500 font-medium mb-1">Belum ada produk</h3>
                <p class="text-sm text-gray-400">Produk akan segera ditambahkan</p>
            </div>
        @endif
    </div>
</section>
