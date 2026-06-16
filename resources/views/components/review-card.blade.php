{{-- Review Card Component --}}
@props(['review'])

<div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition-shadow duration-300">
    {{-- Header: Avatar, Name, Stars, Date --}}
    <div class="flex items-start justify-between gap-4 mb-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('customer.profile.show', $review->user) }}" class="shrink-0">
                <img src="{{ $review->user->avatar_url }}"
                     alt="{{ $review->user->name }}"
                     class="w-10 h-10 rounded-full object-cover ring-2 ring-gray-100 hover:ring-ocean-200 transition-all">
            </a>
            <div>
                <a href="{{ route('customer.profile.show', $review->user) }}"
                   class="font-semibold text-gray-900 hover:text-ocean-600 transition-colors text-sm">
                    {{ $review->user->name }}
                </a>
                <div class="flex items-center gap-2 mt-0.5">
                    {{-- Star Rating --}}
                    <div class="flex items-center gap-0.5">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-3.5 h-3.5 {{ $i <= $review->rating ? 'text-amber-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endfor
                    </div>
                    <span class="text-xs text-gray-400">•</span>
                    <span class="text-xs text-gray-400">{{ $review->created_at->diffForHumans() }}</span>
                </div>
            </div>
        </div>

        {{-- Rating Badge --}}
        <div class="shrink-0">
            @php
                $ratingColor = match(true) {
                    $review->rating >= 4 => 'bg-emerald-50 text-emerald-700',
                    $review->rating >= 3 => 'bg-amber-50 text-amber-700',
                    default => 'bg-red-50 text-red-700',
                };
            @endphp
            <span class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-bold rounded-lg {{ $ratingColor }}">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                {{ $review->rating }}.0
            </span>
        </div>
    </div>

    {{-- Review Text --}}
    @if($review->review_text)
    <div class="mb-4">
        <p class="text-gray-700 text-sm leading-relaxed">{{ $review->review_text }}</p>
    </div>
    @endif

    {{-- Vendor Reply --}}
    @if($review->hasReply())
    <div class="mt-4 pl-4 border-l-2 border-ocean-200 bg-ocean-50/40 rounded-r-xl p-4">
        <div class="flex items-center gap-2 mb-2">
            <div class="w-6 h-6 rounded-full bg-ocean-100 flex items-center justify-center">
                <svg class="w-3.5 h-3.5 text-ocean-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z"/>
                </svg>
            </div>
            <span class="text-xs font-semibold text-ocean-700">Balasan Vendor</span>
            @if($review->vendor_reply_at)
            <span class="text-xs text-gray-400">• {{ $review->vendor_reply_at->diffForHumans() }}</span>
            @endif
        </div>
        <p class="text-sm text-gray-600 leading-relaxed">{{ $review->vendor_reply }}</p>
    </div>
    @endif
</div>
