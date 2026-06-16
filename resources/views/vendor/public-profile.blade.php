<x-app-layout>
<div class="py-8">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        {{-- Vendor Header --}}
        <div class="bg-gradient-to-br from-ocean-600 to-ocean-800 rounded-2xl shadow-xl p-8 text-white mb-8">
            <div class="flex flex-col sm:flex-row items-center gap-6">
                <img src="{{ $vendor->logo_url }}" class="w-24 h-24 rounded-2xl object-cover border-4 border-white/20 shadow-lg" alt="">
                <div class="text-center sm:text-left">
                    <h1 class="text-3xl font-bold">{{ $vendor->shop_name }}</h1>
                    <p class="text-ocean-200 mt-1">{{ $vendor->business_type ? ucfirst($vendor->business_type) : 'Vendor' }} · {{ $vendor->city ?? '' }}</p>
                    <div class="flex items-center gap-4 mt-3 justify-center sm:justify-start">
                        <span class="text-lg font-bold"><x-heroicon-s-star class="w-5 h-5 inline-block text-yellow-400 mr-1"/> {{ $vendor->average_rating }}</span>
                        <span class="text-ocean-300">({{ $vendor->review_count }} ulasan)</span>
                        <span class="text-ocean-300">·</span>
                        <span class="text-ocean-300">{{ $vendor->products()->where('status','active')->count() }} produk</span>
                    </div>
                </div>
            </div>
            @if($vendor->bio)<p class="mt-6 text-ocean-100 text-sm leading-relaxed max-w-2xl">{{ $vendor->bio }}</p>@endif
        </div>

        {{-- Products --}}
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Produk dari {{ $vendor->shop_name }}</h2>
        @if($vendor->products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                @foreach($vendor->products as $product)
                <a href="{{ route('produk.detail', $product->slug) }}" class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-all group">
                    <div class="relative overflow-hidden"><img src="{{ $product->thumbnail_url }}" class="w-full h-44 object-cover group-hover:scale-105 transition-transform duration-300" alt=""></div>
                    <div class="p-4"><h4 class="font-bold text-gray-900 group-hover:text-ocean-600 transition-colors">{{ Str::limit($product->name, 30) }}</h4><p class="text-ocean-600 font-bold mt-1">{{ $product->formatted_price }}</p><p class="text-xs text-gray-500 mt-1">{{ $product->location }}</p></div>
                </a>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 mb-8">Belum ada produk dari vendor ini.</p>
        @endif

        {{-- Reviews --}}
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Ulasan Pelanggan</h2>
        @if($recentReviews->count() > 0)
            <div class="space-y-4">
                @foreach($recentReviews as $review)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-9 h-9 rounded-full bg-ocean-100 flex items-center justify-center text-sm font-bold text-ocean-700">{{ strtoupper(substr($review->user->name ?? 'U', 0, 1)) }}</div>
                        <div><p class="font-semibold text-gray-900 text-sm">{{ $review->user->name ?? 'Anonim' }}</p><p class="text-xs text-gray-500">{{ $review->created_at->diffForHumans() }} · <span class="text-amber-500">{{ $review->stars_html }}</span></p></div>
                    </div>
                    @if($review->review_text)<p class="text-gray-700 text-sm">{{ $review->review_text }}</p>@endif
                    @if($review->vendor_reply)<div class="mt-3 ml-6 p-3 bg-ocean-50 rounded-xl"><p class="text-xs font-semibold text-ocean-700 mb-1">Balasan vendor:</p><p class="text-sm text-gray-700">{{ $review->vendor_reply }}</p></div>@endif
                </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500">Belum ada ulasan.</p>
        @endif
    </div>
</div>
</x-app-layout>
