<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Welcome Banner --}}
            <div class="bg-gradient-to-br from-ocean-500 to-ocean-700 rounded-2xl shadow-lg overflow-hidden relative">
                <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
                <div class="relative p-8 sm:p-10 text-white flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
                    <div>
                        <h3 class="text-3xl font-bold mb-2 flex items-center gap-2">Halo, {{ Auth::user()->name }}!</h3>
                        <p class="text-ocean-100 text-lg">Siap untuk petualangan selanjutnya di pesisir Lampung?</p>
                    </div>
                    <a href="{{ route('catalog') }}" class="shrink-0 bg-white text-ocean-600 font-semibold px-6 py-3 rounded-xl shadow-md hover:bg-ocean-50 transition-all duration-200 active:scale-95">
                        Mulai Eksplorasi
                    </a>
                </div>
            </div>

            {{-- Stats Cards --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 rounded-xl bg-ocean-50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-ocean-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z"/></svg>
                        </div>
                        <span class="text-xs font-medium text-gray-500">Total Booking</span>
                    </div>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_bookings'] }}</p>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="text-xs font-medium text-gray-500">Booking Aktif</span>
                    </div>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['active_bookings'] }}</p>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="text-xs font-medium text-gray-500">Selesai</span>
                    </div>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['completed'] }}</p>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 rounded-xl bg-violet-50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-violet-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="text-xs font-medium text-gray-500">Total Belanja</span>
                    </div>
                    <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($stats['total_spent'], 0, ',', '.') }}</p>
                </div>
            </div>

            {{-- Flash Messages --}}
            @if(session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm flex items-center gap-3">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm flex items-center gap-3">
                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                {{ session('error') }}
            </div>
            @endif

            {{-- Transaction History --}}
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100">
                <div class="p-6 sm:p-8 border-b border-gray-100">
                    <h3 class="text-xl font-bold text-gray-900">Riwayat Pesanan</h3>
                    <p class="text-sm text-gray-500 mt-1">Daftar transaksi dan booking layanan wisata Anda.</p>
                </div>

                <div class="p-6 sm:p-8 bg-gray-50/50">
                    @if($transactions->count() > 0)
                        <div class="space-y-4">
                            @foreach($transactions as $trx)
                            <x-transaction-card :trx="$trx" :reviewedTransactionIds="$reviewedTransactionIds" />
                            @endforeach
                        </div>

                        <div class="mt-6">
                            <x-admin-pagination :paginator="$transactions" />
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="w-20 h-20 mx-auto mb-5 rounded-2xl bg-ocean-50 flex items-center justify-center">
                                <svg class="w-10 h-10 text-ocean-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z"/></svg>
                            </div>
                            <h4 class="text-lg font-bold text-gray-900 mb-2">Belum Ada Transaksi</h4>
                            <p class="text-gray-500 max-w-sm mx-auto mb-6 text-sm">Yuk, temukan penginapan atau kapal untuk liburan Anda!</p>
                            <a href="{{ route('catalog') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-ocean-500 to-ocean-600 text-white text-sm font-semibold rounded-xl shadow-sm hover:from-ocean-600 hover:to-ocean-700 transition-all">
                                Eksplor Destinasi
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
