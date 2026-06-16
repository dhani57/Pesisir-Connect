{{-- Review Summary Component --}}
@props(['ratingSummary'])

@php
    $average   = $ratingSummary['average'] ?? 0;
    $total     = $ratingSummary['total'] ?? 0;
    $breakdown = $ratingSummary['breakdown'] ?? [];
@endphp

<div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100">
    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
        <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
        Ulasan Pelanggan
    </h2>

    @if($total > 0)
    <div class="flex flex-col sm:flex-row gap-8">
        {{-- Rating Besar --}}
        <div class="flex flex-col items-center justify-center sm:min-w-[140px] shrink-0">
            <span class="text-5xl font-extrabold text-gray-900 leading-none">{{ number_format($average, 1) }}</span>
            <div class="flex items-center gap-0.5 mt-2 mb-1">
                @for($i = 1; $i <= 5; $i++)
                    @if($i <= floor($average))
                        <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @elseif($i == ceil($average) && $average - floor($average) >= 0.3)
                        {{-- Half star --}}
                        <div class="relative w-5 h-5">
                            <svg class="w-5 h-5 text-gray-200 absolute inset-0" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <div class="absolute inset-0 overflow-hidden" style="width: {{ ($average - floor($average)) * 100 }}%">
                                <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            </div>
                        </div>
                    @else
                        <svg class="w-5 h-5 text-gray-200" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @endif
                @endfor
            </div>
            <span class="text-sm text-gray-500">{{ $total }} ulasan</span>
        </div>

        {{-- Breakdown Bar Chart --}}
        <div class="flex-1 space-y-2.5">
            @for($star = 5; $star >= 1; $star--)
                @php
                    $count = $breakdown[$star] ?? 0;
                    $percent = $total > 0 ? round(($count / $total) * 100) : 0;
                @endphp
                <div class="flex items-center gap-3 group">
                    <div class="flex items-center gap-1 shrink-0 w-12">
                        <span class="text-sm font-medium text-gray-600">{{ $star }}</span>
                        <svg class="w-3.5 h-3.5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </div>
                    <div class="flex-1 h-2.5 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full rounded-full transition-all duration-700 ease-out {{ $star >= 4 ? 'bg-gradient-to-r from-amber-400 to-amber-300' : ($star >= 3 ? 'bg-amber-300' : 'bg-amber-200') }}"
                             style="width: {{ $percent }}%"></div>
                    </div>
                    <span class="text-xs text-gray-400 w-8 text-right shrink-0">{{ $count }}</span>
                </div>
            @endfor
        </div>
    </div>
    @else
    <div class="text-center py-8">
        <div class="w-16 h-16 mx-auto rounded-full bg-gray-50 flex items-center justify-center mb-4">
            <svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
        </div>
        <h3 class="text-base font-semibold text-gray-700 mb-1">Belum ada ulasan</h3>
        <p class="text-sm text-gray-400">Jadilah yang pertama memberikan ulasan untuk layanan ini.</p>
    </div>
    @endif
</div>
