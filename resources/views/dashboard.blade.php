<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            {{-- Welcome Banner --}}
            <div class="bg-gradient-to-br from-ocean-500 to-ocean-700 rounded-2xl shadow-lg overflow-hidden relative">
                <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
                <div class="relative p-8 sm:p-10 text-white flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
                    <div>
                        <h3 class="text-3xl font-bold mb-2">Halo, {{ Auth::user()->name }}! 👋</h3>
                        <p class="text-ocean-100 text-lg">Siap untuk petualangan selanjutnya di pesisir Lampung?</p>
                    </div>
                    <a href="{{ route('catalog') }}" class="shrink-0 bg-white text-ocean-600 font-semibold px-6 py-3 rounded-xl shadow-md hover:bg-ocean-50 transition-all duration-200 active:scale-95">
                        Mulai Eksplorasi
                    </a>
                </div>
            </div>

            {{-- Transaction History --}}
            @php
                // Dummy data untuk riwayat pesanan (karena query controller belum ada)
                $transactions = []; // Ubah menjadi array berisi objek dummy jika ingin melihat tabel penuh
            @endphp

            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-gray-100">
                <div class="p-6 sm:p-8 border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Riwayat Pesanan</h3>
                        <p class="text-sm text-gray-500 mt-1">Daftar transaksi dan booking layanan wisata Anda.</p>
                    </div>
                </div>

                <div class="p-6 sm:p-8 bg-gray-50/50">
                    @if(count($transactions) > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="text-sm font-semibold text-gray-500 border-b border-gray-200">
                                        <th class="pb-3 px-4">Order ID</th>
                                        <th class="pb-3 px-4">Layanan</th>
                                        <th class="pb-3 px-4">Tanggal</th>
                                        <th class="pb-3 px-4">Total</th>
                                        <th class="pb-3 px-4">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Loop jika ada transaksi --}}
                                    @foreach($transactions as $trx)
                                        <tr class="border-b border-gray-100 last:border-0 hover:bg-white transition-colors">
                                            <td class="py-4 px-4 font-medium text-gray-900">#{{ $trx->order_id }}</td>
                                            <td class="py-4 px-4 text-gray-600">{{ $trx->product_name }}</td>
                                            <td class="py-4 px-4 text-gray-600">{{ $trx->date }}</td>
                                            <td class="py-4 px-4 text-gray-900 font-semibold">{{ $trx->total }}</td>
                                            <td class="py-4 px-4">
                                                <span class="px-3 py-1 text-xs font-medium bg-emerald-100 text-emerald-700 rounded-full">Selesai</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        {{-- Empty State --}}
                        <div class="text-center py-12">
                            <div class="w-20 h-20 mx-auto mb-5 rounded-2xl bg-ocean-50 flex items-center justify-center">
                                <svg class="w-10 h-10 text-ocean-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 010 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 010-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375z" />
                                </svg>
                            </div>
                            <h4 class="text-lg font-bold text-gray-900 mb-2">Belum Ada Transaksi</h4>
                            <p class="text-gray-500 max-w-sm mx-auto mb-6 text-sm">
                                Sepertinya Anda belum memesan layanan apapun. Yuk, temukan penginapan atau kapal untuk liburan Anda!
                            </p>
                            <a href="{{ route('catalog') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-ocean-500 to-ocean-600 text-white text-sm font-semibold rounded-xl shadow-sm hover:from-ocean-600 hover:to-ocean-700 transition-all duration-200">
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
