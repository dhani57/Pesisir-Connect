<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profil {{ $user->name }} — PesisirConnect</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
</head>
<body class="antialiased bg-gray-50">

    <x-navbar :always-scrolled="true" />

    <main class="pt-24 pb-16 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Profile Header Card --}}
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden mb-8">
                <div class="h-32 md:h-48 bg-gradient-to-r from-ocean-500 to-ocean-700 w-full relative">
                    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
                </div>
                
                <div class="px-6 md:px-10 pb-8 relative">
                    <div class="flex flex-col md:flex-row gap-6 md:items-end -mt-16 md:-mt-20 mb-6">
                        <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" 
                             class="w-32 h-32 md:w-40 md:h-40 rounded-full border-4 border-white shadow-lg object-cover bg-white">
                        
                        <div class="flex-1">
                            <h1 class="text-3xl font-bold text-gray-900">{{ $user->name }}</h1>
                            <p class="text-gray-500 mt-1 flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                Bergabung sejak {{ $stats['member_since']->translatedFormat('F Y') }}
                            </p>
                        </div>
                        
                        @if(auth()->id() === $user->id)
                        <div class="shrink-0 mt-4 md:mt-0">
                            <a href="{{ route('customer.profile.edit') }}" class="btn-outline !py-2.5">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                Edit Profil
                            </a>
                        </div>
                        @endif
                    </div>
                    
                    @if($user->bio)
                        <div class="prose prose-sm text-gray-600 max-w-none">
                            <p>{{ $user->bio }}</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Statistics Grid --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm text-center">
                    <div class="w-10 h-10 mx-auto rounded-full bg-ocean-50 text-ocean-600 flex items-center justify-center mb-3">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z"/></svg>
                    </div>
                    <p class="text-xs text-gray-500 font-medium uppercase tracking-wider mb-1">Total Booking</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_bookings'] }}</p>
                </div>
                <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm text-center">
                    <div class="w-10 h-10 mx-auto rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center mb-3">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <p class="text-xs text-gray-500 font-medium uppercase tracking-wider mb-1">Trip Selesai</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['completed'] }}</p>
                </div>
                <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm text-center">
                    <div class="w-10 h-10 mx-auto rounded-full bg-amber-50 text-amber-600 flex items-center justify-center mb-3">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                    </div>
                    <p class="text-xs text-gray-500 font-medium uppercase tracking-wider mb-1">Ulasan</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $reviews->total() }}</p>
                </div>
            </div>

            {{-- Reviews List --}}
            <div>
                <h2 class="text-xl font-bold text-gray-900 mb-6">Ulasan yang Diberikan</h2>
                
                @if($reviews->count() > 0)
                    <div class="space-y-4">
                        @foreach($reviews as $review)
                        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                            <div class="flex items-start justify-between gap-4 mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-gray-100 overflow-hidden shrink-0">
                                        <img src="{{ $review->transaction->product->thumbnail_url ?? '' }}" class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <a href="{{ route('produk.detail', $review->transaction->product->slug ?? '') }}" class="font-bold text-gray-900 hover:text-ocean-600 transition-colors">
                                            {{ $review->transaction->product->name ?? 'Produk' }}
                                        </a>
                                        <p class="text-xs text-gray-500 flex items-center gap-1">
                                            <span>Oleh {{ $review->vendor->shop_name }}</span>
                                            <span>&bull;</span>
                                            <span>{{ $review->created_at->diffForHumans() }}</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="text-amber-400 text-lg tracking-widest shrink-0" title="Rating: {{ $review->rating }}/5">
                                    {{ $review->stars_html }}
                                </div>
                            </div>
                            
                            @if($review->review_text)
                            <p class="text-gray-700 text-sm leading-relaxed">{{ $review->review_text }}</p>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-8">
                        {{ $reviews->links() }}
                    </div>
                @else
                    <div class="text-center py-12 bg-white rounded-2xl border border-gray-100">
                        <div class="w-16 h-16 mx-auto rounded-full bg-gray-50 flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Belum ada ulasan</h3>
                        <p class="text-gray-500 text-sm mt-1">Pengguna ini belum memberikan ulasan apapun.</p>
                    </div>
                @endif
            </div>

        </div>
    </main>

    <x-footer />
</body>
</html>
