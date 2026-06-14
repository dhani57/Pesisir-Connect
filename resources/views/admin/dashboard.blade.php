<x-admin-layout title="Admin Dashboard">
    
    <!-- Page Header -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">Ringkasan Sistem</h2>
        <p class="mt-1 text-sm leading-6 text-gray-500">Pantau aktivitas platform Pesisir Connect secara real-time.</p>
    </div>

    <!-- Stat Cards Grid -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 mb-8">
        <x-admin-stat-card 
            title="Nilai Transaksi (GMV)" 
            value="Rp {{ number_format($totalRevenue, 0, ',', '.') }}" 
            color="sky"
        >
            <x-slot name="icon">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </x-slot>
        </x-admin-stat-card>

        <x-admin-stat-card 
            title="Komisi Platform" 
            value="Rp {{ number_format($netCommission, 0, ',', '.') }}" 
            color="emerald"
        >
            <x-slot name="icon">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                </svg>
            </x-slot>
        </x-admin-stat-card>

        <x-admin-stat-card 
            title="Vendor Aktif" 
            value="{{ number_format($activeVendors, 0, ',', '.') }}" 
            color="sky"
        >
            <x-slot name="icon">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z" />
                </svg>
            </x-slot>
        </x-admin-stat-card>

        <x-admin-stat-card 
            title="Transaksi Sukses" 
            value="{{ number_format($successfulTransactions, 0, ',', '.') }}" 
            color="coral"
        >
            <x-slot name="icon">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                </svg>
            </x-slot>
        </x-admin-stat-card>

        <x-admin-stat-card 
            title="Menunggu Verifikasi" 
            value="{{ number_format($pendingVendorsCount, 0, ',', '.') }}" 
            color="amber"
        >
            <x-slot name="icon">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </x-slot>
        </x-admin-stat-card>
    </div>



    <!-- Dua Kolom: Transaksi Terbaru & Vendor Menunggu -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Transaksi Terbaru -->
        <div class="bg-white shadow-sm ring-1 ring-gray-200 sm:rounded-2xl overflow-hidden flex flex-col">
            <div class="border-b border-gray-200 bg-gray-50/50 px-6 py-5 sm:flex sm:items-center sm:justify-between">
                <h3 class="text-base font-semibold leading-6 text-gray-900">Transaksi Terbaru</h3>
                <a href="{{ route('admin.transactions.index') }}" class="text-sm font-semibold text-sky-600 hover:text-sky-500 mt-3 sm:mt-0">Lihat Semua &rarr;</a>
            </div>
            <div class="flex-1 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse($recentTransactions as $trx)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $trx->invoice_number }}</div>
                                    <div class="text-xs text-gray-500 mt-1">{{ $trx->created_at->format('d M Y, H:i') }}</div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="text-sm text-gray-900">{{ $trx->customer->name ?? 'User' }}</div>
                                    <div class="text-xs text-gray-500 mt-1">{{ $trx->product->name ?? 'Produk' }}</div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-right">
                                    <div class="text-sm font-semibold text-gray-900">{{ $trx->formatted_total }}</div>
                                    <div class="mt-1">
                                        @if($trx->status === 'paid')
                                            <span class="inline-flex items-center rounded-md bg-emerald-50 px-2 py-1 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/20">Sukses</span>
                                        @elseif($trx->status === 'pending')
                                            <span class="inline-flex items-center rounded-md bg-amber-50 px-2 py-1 text-xs font-medium text-amber-700 ring-1 ring-inset ring-amber-600/20">Pending</span>
                                        @else
                                            <span class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-700 ring-1 ring-inset ring-gray-600/20">{{ ucfirst($trx->status) }}</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-sm text-gray-500">Belum ada transaksi terbaru.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Vendor Menunggu Verifikasi -->
        <div class="bg-white shadow-sm ring-1 ring-gray-200 sm:rounded-2xl overflow-hidden flex flex-col">
            <div class="border-b border-gray-200 bg-gray-50/50 px-6 py-5 sm:flex sm:items-center sm:justify-between">
                <h3 class="text-base font-semibold leading-6 text-gray-900">Perlu Verifikasi</h3>
                <a href="{{ route('admin.vendors.index') }}" class="text-sm font-semibold text-sky-600 hover:text-sky-500 mt-3 sm:mt-0">Kelola Vendor &rarr;</a>
            </div>
            <div class="flex-1 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse($pendingVendors as $vendor)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 flex-shrink-0">
                                            <img class="h-10 w-10 rounded-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode($vendor->name) }}&background=fef3c7&color=b45309" alt="">
                                        </div>
                                        <div class="ml-4">
                                            <div class="font-medium text-gray-900">{{ $vendor->name }}</div>
                                            <div class="text-xs text-gray-500 mt-0.5">{{ $vendor->vendor->shop_name ?? 'Belum isi profil' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-right">
                                    <a href="{{ route('admin.vendors.show', $vendor) }}" class="inline-flex items-center gap-x-1.5 rounded-md bg-white px-2.5 py-1.5 text-xs font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                                        Tinjau
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-6 py-8 text-center text-sm text-gray-500">
                                    <svg class="mx-auto h-8 w-8 text-emerald-400 mb-3" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                    Semua vendor telah diverifikasi!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Grafik Perkembangan Transaksi -->
    <div class="mt-8">
        <x-admin-chart 
            :labels="$chartLabels" 
            :revenue="$chartRevenue" 
            :count="$chartCount" 
        />
    </div>
</x-admin-layout>
