<x-vendor-layout :title="'Profil Toko'">
<div class="max-w-4xl mx-auto">
    <div class="bg-gradient-to-br from-ocean-600 to-ocean-800 rounded-2xl shadow-xl p-8 text-white mb-8">
        <div class="flex flex-col sm:flex-row items-center gap-6">
            <img src="{{ $vendor->logo_url }}" class="w-24 h-24 rounded-2xl object-cover border-4 border-white/20 shadow-lg" alt="">
            <div class="text-center sm:text-left">
                <h1 class="text-3xl font-bold">{{ $vendor->shop_name }}</h1>
                <p class="text-ocean-200 mt-1">{{ $vendor->business_type ? ucfirst($vendor->business_type) : 'Vendor' }} · Bergabung {{ $vendor->created_at->format('M Y') }}</p>
                <div class="flex items-center gap-4 mt-3 justify-center sm:justify-start">
                    <span class="text-lg font-bold"><x-heroicon-s-star class="w-5 h-5 inline-block text-yellow-400 mr-1"/> {{ $vendor->average_rating }}</span>
                    <span class="text-ocean-300">({{ $vendor->review_count }} ulasan)</span>
                    <span class="text-ocean-300">·</span>
                    <span class="text-ocean-300">{{ $vendor->products()->count() }} produk</span>
                </div>
            </div>
        </div>
        @if($vendor->bio)
            <p class="mt-6 text-ocean-100 text-sm leading-relaxed">{{ $vendor->bio }}</p>
        @endif
    </div>

    {{-- Featured Products --}}
    <div class="mb-8">
        <h3 class="text-xl font-bold text-gray-900 mb-4">Produk Unggulan</h3>
        @if($vendor->products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach($vendor->products as $product)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
                    <img src="{{ $product->thumbnail_url }}" class="w-full h-40 object-cover" alt="">
                    <div class="p-4">
                        <h4 class="font-bold text-gray-900">{{ $product->name }}</h4>
                        <p class="text-ocean-600 font-bold mt-1">{{ $product->formatted_price }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-sm">Belum ada produk.</p>
        @endif
    </div>

    {{-- Reviews --}}
    <div>
        <h3 class="text-xl font-bold text-gray-900 mb-4">Ulasan Terbaru</h3>
        @if($recentReviews->count() > 0)
            <div class="space-y-4">
                @foreach($recentReviews as $review)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-8 h-8 rounded-full bg-ocean-100 flex items-center justify-center text-sm font-bold text-ocean-700">{{ strtoupper(substr($review->user->name ?? 'U', 0, 1)) }}</div>
                        <div><p class="font-semibold text-gray-900 text-sm">{{ $review->user->name ?? 'Anonim' }}</p><p class="text-xs text-gray-500">{{ $review->created_at->diffForHumans() }}</p></div>
                        <span class="ml-auto text-amber-500 font-bold">{{ $review->stars_html }}</span>
                    </div>
                    @if($review->review_text)<p class="text-gray-700 text-sm">{{ $review->review_text }}</p>@endif
                    @if($review->vendor_reply)
                        <div class="mt-3 ml-6 p-3 bg-ocean-50 rounded-xl"><p class="text-xs font-semibold text-ocean-700 mb-1">Balasan vendor:</p><p class="text-sm text-gray-700">{{ $review->vendor_reply }}</p></div>
                    @endif
                </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-sm">Belum ada ulasan.</p>
        @endif
    </div>
</div>
</x-vendor-layout>
