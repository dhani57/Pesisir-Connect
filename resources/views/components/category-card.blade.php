{{-- Category Card Component --}}
@props(['category'])

<a href="{{ route('catalog', ['category' => $category->slug]) }}"
   class="category-card group block relative h-52 sm:h-64 rounded-2xl overflow-hidden"
   id="category-{{ $category->slug }}">

    {{-- Background Image --}}
    <img src="{{ $category->image ? (Str::startsWith($category->image, ['http://', 'https://']) ? $category->image : Storage::url($category->image)) : asset('images/categories/boat.png') }}"
         alt="{{ $category->name }}"
         loading="lazy"
         decoding="async"
         class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">

    {{-- Gradient Overlay --}}
    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>

    {{-- Content --}}
    <div class="absolute bottom-0 left-0 right-0 p-5">
        <h3 class="text-white font-bold text-lg sm:text-xl mb-1">{{ $category->name }}</h3>
        <p class="text-white/70 text-xs sm:text-sm">{{ $category->products_count ?? 0 }} layanan tersedia</p>
    </div>

    {{-- Hover Indicator --}}
    <div class="absolute top-4 right-4 w-8 h-8 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
    </div>
</a>
