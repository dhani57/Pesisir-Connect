{{-- Product Card Component --}}
@props(['product'])

<div class="product-card group" id="product-{{ $product->id }}">
    {{-- Image --}}
    <div class="card-image">
        <img src="{{ $product->thumbnail_url }}"
             alt="{{ $product->name }}"
             loading="lazy"
             class="w-full h-48 sm:h-52 object-cover">

        {{-- Badges --}}
        <div class="absolute top-3 left-3 flex flex-wrap gap-1.5">
            @if($product->is_featured)
                <span class="badge bg-amber-400/90 text-amber-900 backdrop-blur-sm">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    Unggulan
                </span>
            @endif
            <span class="badge bg-white/90 text-gray-700 backdrop-blur-sm">
                {{ $product->category->name }}
            </span>
        </div>
    </div>

    {{-- Content --}}
    <div class="p-4 sm:p-5">
        {{-- Location --}}
        <div class="flex items-center gap-1 text-gray-400 text-xs mb-2">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            {{ $product->location }}
        </div>

        {{-- Name --}}
        <h3 class="font-semibold text-gray-900 text-sm sm:text-base leading-snug mb-2 line-clamp-2 group-hover:text-ocean-600 transition-colors">
            {{ $product->name }}
        </h3>

        {{-- Rating --}}
        @if($product->total_reviews > 0)
            <div class="flex items-center gap-1.5 mb-3">
                <div class="flex items-center gap-0.5">
                    @for($i = 1; $i <= 5; $i++)
                        <svg class="w-3.5 h-3.5 {{ $i <= round($product->rating) ? 'text-amber-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @endfor
                </div>
                <span class="text-xs text-gray-500">{{ number_format($product->rating, 1) }} ({{ $product->total_reviews }})</span>
            </div>
        @endif

        {{-- Facilities --}}
        @if($product->facilities)
            <div class="flex flex-wrap gap-1.5 mb-3">
                @foreach(array_slice($product->facilities, 0, 3) as $facility)
                    <span class="text-[10px] sm:text-xs px-2 py-0.5 rounded-md bg-ocean-50 text-ocean-700">{{ $facility }}</span>
                @endforeach
                @if(count($product->facilities) > 3)
                    <span class="text-[10px] sm:text-xs px-2 py-0.5 rounded-md bg-gray-100 text-gray-500">+{{ count($product->facilities) - 3 }}</span>
                @endif
            </div>
        @endif

        {{-- Price & CTA --}}
        <div class="flex items-end justify-between pt-3 border-t border-gray-100">
            <div>
                <span class="text-xs text-gray-400">Mulai dari</span>
                <div class="flex items-baseline gap-1">
                    <span class="text-lg sm:text-xl font-bold text-ocean-600">{{ $product->formatted_price }}</span>
                    <span class="text-xs text-gray-400">/{{ $product->price_unit }}</span>
                </div>
            </div>
            <a href="{{ route('produk.detail', $product->slug) }}"
               class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-ocean-600 text-white text-xs font-semibold hover:bg-ocean-700 active:scale-95 transition-all duration-200 shadow-sm shadow-ocean-600/25">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                Detail
            </a>
        </div>
    </div>
</div>
