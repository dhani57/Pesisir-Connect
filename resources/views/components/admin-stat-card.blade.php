@props(['title', 'value', 'icon', 'color' => 'sky'])

@php
    $colorClasses = [
        'sky' => 'bg-sky-100 text-sky-600 border-sky-200',
        'coral' => 'bg-rose-100 text-rose-600 border-rose-200',
        'emerald' => 'bg-emerald-100 text-emerald-600 border-emerald-200',
        'amber' => 'bg-amber-100 text-amber-600 border-amber-200',
    ];
    $iconColor = $colorClasses[$color] ?? $colorClasses['sky'];
@endphp

<div class="relative overflow-hidden rounded-3xl bg-white p-6 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] border border-gray-100 hover:shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:border-sky-100 transition-all duration-300 group">
    <div class="flex items-center gap-5">
        <!-- Icon Container -->
        <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl border {{ $iconColor }} group-hover:scale-110 transition-transform duration-300">
            {{ $icon }}
        </div>
        
        <!-- Text -->
        <div class="z-10">
            <p class="text-sm font-medium text-gray-500 mb-1">{{ $title }}</p>
            <p class="text-3xl font-bold tracking-tight text-gray-900">{{ $value }}</p>
        </div>
    </div>
    
    <!-- Decorative subtle gradient blob -->
    <div class="absolute -right-6 -top-6 h-32 w-32 rounded-full bg-gradient-to-br from-gray-50 to-gray-100 opacity-50 blur-2xl group-hover:from-sky-50 group-hover:to-white transition-colors duration-500 pointer-events-none"></div>
</div>
