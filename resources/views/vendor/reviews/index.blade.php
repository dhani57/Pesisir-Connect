<x-vendor-layout :title="'Ulasan'">
<div class="mb-6"><h2 class="text-2xl font-bold text-gray-900">Ulasan Pelanggan</h2><p class="text-sm text-gray-500 mt-1">Kelola ulasan dan rating dari pelanggan</p></div>

{{-- Stats --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 text-center"><p class="text-3xl font-bold text-amber-500">⭐ {{ $avgRating }}</p><p class="text-xs text-gray-500 mt-1">Rating Rata-rata</p></div>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 text-center"><p class="text-3xl font-bold text-gray-900">{{ $reviewCount }}</p><p class="text-xs text-gray-500 mt-1">Total Ulasan</p></div>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 text-center"><p class="text-3xl font-bold text-ocean-600">{{ $responseRate }}%</p><p class="text-xs text-gray-500 mt-1">Response Rate</p></div>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
        <p class="text-xs text-gray-500 font-semibold mb-2">Distribusi</p>
        @for($i = 5; $i >= 1; $i--)
            <div class="flex items-center gap-2 text-xs mb-1"><span class="w-3">{{ $i }}★</span><div class="flex-1 bg-gray-100 rounded-full h-2"><div class="bg-amber-400 rounded-full h-2" style="width: {{ $reviewCount > 0 ? ($ratingDist[$i] / $reviewCount * 100) : 0 }}%"></div></div><span class="w-6 text-right text-gray-500">{{ $ratingDist[$i] }}</span></div>
        @endfor
    </div>
</div>

{{-- Filters --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-6">
    <form method="GET" class="flex flex-wrap gap-3">
        <select name="rating" class="rounded-xl border-gray-300 focus:border-ocean-500 focus:ring-ocean-500 text-sm"><option value="">Semua Rating</option>@for($i=5;$i>=1;$i--)<option value="{{ $i }}" {{ request('rating')==$i?'selected':'' }}>{{ $i }} Bintang</option>@endfor</select>
        <select name="sort" class="rounded-xl border-gray-300 focus:border-ocean-500 focus:ring-ocean-500 text-sm"><option value="created_at" {{ request('sort')=='created_at'?'selected':'' }}>Terbaru</option><option value="rating" {{ request('sort')=='rating'?'selected':'' }}>Rating</option><option value="helpful_count" {{ request('sort')=='helpful_count'?'selected':'' }}>Paling Membantu</option></select>
        <button type="submit" class="bg-ocean-500 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-ocean-600 transition-colors">Filter</button>
    </form>
</div>

{{-- Reviews List --}}
<div class="space-y-4">
    @forelse($reviews as $review)
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 {{ $review->is_hidden ? 'opacity-60' : '' }}">
        <div class="flex items-start justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-ocean-100 flex items-center justify-center font-bold text-ocean-700">{{ strtoupper(substr($review->user->name ?? 'U', 0, 1)) }}</div>
                <div>
                    <p class="font-semibold text-gray-900">{{ $review->user->name ?? 'Anonim' }}</p>
                    <div class="flex items-center gap-2 text-xs text-gray-500"><span class="text-amber-500">{{ $review->stars_html }}</span><span>·</span><span>{{ $review->created_at->diffForHumans() }}</span>@if($review->transaction && $review->transaction->product)<span>·</span><span>{{ $review->transaction->product->name }}</span>@endif</div>
                </div>
            </div>
            <div class="flex gap-1">
                <form method="POST" action="{{ route('vendor.reviews.toggle-hide', $review) }}">@csrf @method('PATCH')
                    <button type="submit" class="p-2 rounded-lg hover:bg-gray-100 text-gray-500" title="{{ $review->is_hidden ? 'Tampilkan' : 'Sembunyikan' }}"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $review->is_hidden ? 'M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z' : 'M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21' }}"/></svg></button>
                </form>
            </div>
        </div>
        @if($review->review_text)<p class="mt-3 text-gray-700 text-sm">{{ $review->review_text }}</p>@endif
        @if($review->is_hidden)<span class="inline-block mt-2 px-2 py-1 bg-red-100 text-red-700 text-xs rounded-full font-semibold">Disembunyikan</span>@endif

        {{-- Vendor Reply --}}
        @if($review->vendor_reply)
            <div class="mt-4 ml-6 p-4 bg-ocean-50 rounded-xl"><p class="text-xs font-semibold text-ocean-700 mb-1">Balasan Anda · {{ $review->vendor_reply_at?->diffForHumans() }}</p><p class="text-sm text-gray-700">{{ $review->vendor_reply }}</p></div>
        @else
            <div x-data="{ open: false }" class="mt-4">
                <button @click="open = !open" class="text-sm text-ocean-600 hover:text-ocean-700 font-semibold">💬 Balas ulasan</button>
                <form x-show="open" method="POST" action="{{ route('vendor.reviews.reply', $review) }}" class="mt-2 ml-6">@csrf
                    <textarea name="vendor_reply" rows="2" class="w-full rounded-xl border-gray-300 focus:border-ocean-500 focus:ring-ocean-500 text-sm" placeholder="Tulis balasan..." required></textarea>
                    <button type="submit" class="mt-2 bg-ocean-500 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-ocean-600 transition-colors">Kirim Balasan</button>
                </form>
            </div>
        @endif
    </div>
    @empty
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center"><p class="text-gray-500">Belum ada ulasan.</p></div>
    @endforelse
</div>
<div class="mt-6">{{ $reviews->links() }}</div>
</x-vendor-layout>
