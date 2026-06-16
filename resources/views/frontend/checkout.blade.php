<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Checkout — {{ $product->name }} — PesisirConnect</title>

    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🌊</text></svg>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <style>[x-cloak] { display: none !important; }</style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50">

    <x-navbar :always-scrolled="true" />

    <main class="pt-24 pb-16 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Breadcrumbs --}}
            <nav class="flex text-sm text-gray-500 mb-8" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li><a href="{{ route('home') }}" class="hover:text-ocean-600 transition-colors">Beranda</a></li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-gray-400 mx-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                            <a href="{{ route('produk.detail', $product->slug) }}" class="hover:text-ocean-600 transition-colors truncate max-w-[120px] md:max-w-none">{{ $product->name }}</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-gray-400 mx-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                            <span class="text-gray-800 font-medium">Checkout</span>
                        </div>
                    </li>
                </ol>
            </nav>

            {{-- Flash Messages --}}
            @if(session('error'))
                <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm flex items-center gap-3">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                    {{ session('error') }}
                </div>
            @endif

            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-8">Review Pesanan</h1>

            <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form"
                  x-data="{ 
                      quantity: {{ $quantity }}, 
                      unitPrice: {{ $product->discounted_price }},
                      basePrice: {{ $product->price }},
                      get totalPrice() { return this.unitPrice * this.quantity },
                      get totalDiscount() { return (this.basePrice * this.quantity) - this.totalPrice },
                      formatRupiah(amount) { return new Intl.NumberFormat('id-ID').format(amount) }
                  }">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="check_in" value="{{ $checkIn }}">
                <input type="hidden" name="check_out" value="{{ $checkOut }}">

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    {{-- Left: Order Details --}}
                    <div class="lg:col-span-2 space-y-6">

                        {{-- Product Card --}}
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                            <h2 class="text-lg font-bold text-gray-900 mb-4">Detail Layanan</h2>
                            <div class="flex gap-4">
                                <div class="w-24 h-24 sm:w-32 sm:h-24 rounded-xl overflow-hidden shrink-0 bg-gray-100">
                                    <img src="{{ $product->thumbnail_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <span class="inline-block px-2.5 py-0.5 text-xs font-semibold rounded-full bg-ocean-50 text-ocean-700 mb-2">{{ $product->category->name }}</span>
                                    <h3 class="font-bold text-gray-900 text-lg leading-tight">{{ $product->name }}</h3>
                                    <div class="flex items-center gap-4 mt-2 text-sm text-gray-500">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            {{ $product->location }}
                                        </span>
                                        @if($product->vendor)
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            {{ $product->vendor->shop_name }}
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Booking Details --}}
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                            <h2 class="text-lg font-bold text-gray-900 mb-4">Detail Booking</h2>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                                <div class="bg-gray-50 rounded-xl p-4">
                                    <span class="text-xs text-gray-500 block mb-1">Check-in</span>
                                    <span class="font-semibold text-gray-900">{{ $checkIn ? \Carbon\Carbon::parse($checkIn)->translatedFormat('d M Y') : '-' }}</span>
                                </div>
                                <div class="bg-gray-50 rounded-xl p-4">
                                    <span class="text-xs text-gray-500 block mb-1">Check-out</span>
                                    <span class="font-semibold text-gray-900">{{ $checkOut ? \Carbon\Carbon::parse($checkOut)->translatedFormat('d M Y') : '-' }}</span>
                                </div>
                                <div class="bg-gray-50 rounded-xl p-4">
                                    <span class="text-xs text-gray-500 block mb-1">Jumlah</span>
                                    <span class="font-semibold text-gray-900"><span x-text="quantity"></span> {{ $product->price_unit }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Guest Info --}}
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                            <h2 class="text-lg font-bold text-gray-900 mb-5">Informasi Tamu</h2>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Lengkap</label>
                                    <input type="text" value="{{ auth()->user()->name }}" disabled 
                                           class="w-full rounded-xl border-gray-200 bg-gray-50 text-gray-500 text-sm cursor-not-allowed py-2.5 px-4 shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Alamat Email</label>
                                    <input type="email" value="{{ auth()->user()->email }}" disabled 
                                           class="w-full rounded-xl border-gray-200 bg-gray-50 text-gray-500 text-sm cursor-not-allowed py-2.5 px-4 shadow-sm truncate">
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                                <div>
                                    <label for="quantity" class="block text-sm font-semibold text-gray-700 mb-1.5">Jumlah {{ ucfirst($product->price_unit) }}</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                        </div>
                                        <input type="number" id="quantity" name="quantity" min="1" x-model.number="quantity"
                                               class="w-full pl-11 pr-4 py-2.5 rounded-xl border-gray-200 text-sm font-medium text-gray-900 focus:border-ocean-500 focus:ring-ocean-500 shadow-sm transition-colors">
                                    </div>
                                </div>
                                @if(strtolower($product->price_unit) !== 'orang' && strtolower($product->price_unit) !== 'pax')
                                <div>
                                    <label for="guests" class="block text-sm font-semibold text-gray-700 mb-1.5">Jumlah Tamu / Penumpang</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                        </div>
                                        <input type="number" id="guests" name="guests" min="1" value="{{ old('guests', $quantity) }}"
                                               class="w-full pl-11 pr-4 py-2.5 rounded-xl border-gray-200 text-sm font-medium text-gray-900 focus:border-ocean-500 focus:ring-ocean-500 shadow-sm transition-colors">
                                    </div>
                                </div>
                                @endif
                            </div>
                            
                            <div>
                                <label for="notes" class="block text-sm font-semibold text-gray-700 mb-1.5">Catatan (Opsional)</label>
                                <textarea id="notes" name="notes" rows="3" maxlength="500" placeholder="Permintaan khusus, alergi, atau info tambahan..."
                                          class="w-full rounded-xl border-gray-200 text-sm text-gray-900 focus:border-ocean-500 focus:ring-ocean-500 shadow-sm transition-colors p-4">{{ old('notes') }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Right: Order Summary --}}
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:sticky lg:top-28">
                            <h2 class="text-lg font-bold text-gray-900 mb-4">Ringkasan Pembayaran</h2>

                            <div class="space-y-3 text-sm border-b border-gray-100 pb-4 mb-4">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Harga per {{ $product->price_unit }}</span>
                                    <span class="text-gray-900 font-medium">Rp {{ number_format($unitPrice, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Jumlah</span>
                                    <span class="text-gray-900 font-medium">× <span x-text="quantity"></span></span>
                                </div>
                                @if($product->discount > 0)
                                <div class="flex justify-between text-emerald-600" x-show="totalDiscount > 0" x-cloak>
                                    <span>Diskon {{ $product->discount_type === 'percentage' ? $product->discount . '%' : '' }}</span>
                                    <span class="font-medium">-Rp <span x-text="formatRupiah(totalDiscount)"></span></span>
                                </div>
                                @endif
                            </div>

                            <div class="flex justify-between items-center mb-6">
                                <span class="text-base font-bold text-gray-900">Total</span>
                                <span class="text-xl font-extrabold text-ocean-600">Rp <span x-text="formatRupiah(totalPrice)"></span></span>
                            </div>

                            <button type="submit" id="btn-pay" class="w-full inline-flex justify-center items-center gap-2 px-4 py-3.5 bg-ocean-600 hover:bg-ocean-700 text-white text-sm font-bold rounded-xl transition-colors active:scale-[0.98] shadow-md shadow-ocean-600/20 disabled:opacity-50 disabled:cursor-not-allowed">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                Bayar Sekarang
                            </button>

                            <p class="text-center text-xs text-gray-400 mt-4 flex items-center justify-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                Pembayaran aman via Midtrans
                            </p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>

    <x-footer />
</body>
</html>
