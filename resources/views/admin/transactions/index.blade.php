<x-admin-layout title="Audit Finansial Global">
    <!-- Header -->
    <div class="sm:flex sm:items-center sm:justify-between mb-8">
        <div>
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">Audit Finansial Global</h2>
            <p class="mt-1 text-sm leading-6 text-gray-500">Memantau seluruh arus kas masuk dari transaksi produk milik semua vendor.</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <x-admin-search placeholder="Cari invoice, pelanggan, atau produk..." />
        </div>
    </div>

    <!-- Transactions Container -->
    <div id="table-container" class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
        
        <!-- Mobile Card View (Hidden on sm and up) -->
        <div class="block sm:hidden divide-y divide-gray-200">
            @forelse($transactions as $trx)
                <div class="p-4 hover:bg-gray-50 transition-colors">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-gray-900">{{ $trx->invoice_number }}</span>
                        @if($trx->status === 'paid')
                            <span class="inline-flex items-center rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/20">Success</span>
                        @elseif($trx->status === 'pending')
                            <span class="inline-flex items-center rounded-full bg-amber-50 px-2 py-0.5 text-xs font-medium text-amber-700 ring-1 ring-inset ring-amber-600/20">Pending</span>
                        @else
                            <span class="inline-flex items-center rounded-full bg-rose-50 px-2 py-0.5 text-xs font-medium text-rose-700 ring-1 ring-inset ring-rose-600/20">{{ ucfirst($trx->status) }}</span>
                        @endif
                    </div>
                    <div class="mb-1 text-sm text-gray-600">
                        <span class="font-medium text-gray-900">{{ $trx->customer->name ?? 'Guest' }}</span> membeli <span class="font-medium">{{ Str::limit($trx->product->name ?? 'Produk Dihapus', 20) }}</span>
                    </div>
                    <div class="mb-3 text-xs text-gray-500">
                        Vendor: {{ $trx->product->vendor->name ?? '-' }}
                    </div>
                    <div class="flex items-center justify-between border-t border-gray-100 pt-2 mt-2">
                        <span class="text-xs text-gray-500">{{ $trx->created_at->format('d M Y H:i') }}</span>
                        <div class="flex items-center gap-2">
                            @if($trx->payment_method)
                                <span class="text-xs text-gray-500 uppercase">{{ $trx->payment_method }}</span>
                            @endif
                            <span class="font-bold text-gray-900">{{ $trx->formatted_total }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-sm text-gray-500">
                    Belum ada transaksi yang tercatat di platform.
                </div>
            @endforelse
        </div>

        <!-- Desktop Table View (Hidden on mobile) -->
        <div class="hidden sm:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-16">No.</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Invoice & Tgl</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Customer</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Produk & Vendor</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Pembayaran</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse($transactions as $trx)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 font-medium">
                                {{ $transactions->firstItem() + $loop->index }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="font-medium text-gray-900">{{ $trx->invoice_number }}</div>
                                <div class="text-xs text-gray-500">{{ $trx->created_at->format('d M Y H:i') }}</div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="font-medium text-gray-900">{{ $trx->customer->name ?? 'Guest' }}</div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="font-medium text-gray-900">{{ Str::limit($trx->product->name ?? 'Produk Dihapus', 25) }}</div>
                                <div class="text-xs text-gray-500">Vendor: {{ $trx->product->vendor->name ?? '-' }}</div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="font-bold text-gray-900">{{ $trx->formatted_total }}</div>
                                @if($trx->payment_method)
                                    <div class="text-xs text-gray-500 uppercase">{{ $trx->payment_method }}</div>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                @if($trx->status === 'paid')
                                    <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                                        Success
                                    </span>
                                @elseif($trx->status === 'pending')
                                    <span class="inline-flex items-center rounded-full bg-amber-50 px-2.5 py-0.5 text-xs font-medium text-amber-700 ring-1 ring-inset ring-amber-600/20">
                                        Pending
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-rose-50 px-2.5 py-0.5 text-xs font-medium text-rose-700 ring-1 ring-inset ring-rose-600/20">
                                        {{ ucfirst($trx->status) }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-sm text-gray-500">
                                Belum ada transaksi yang tercatat di platform.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="border-t border-gray-200 px-6 py-4">
            <x-admin-pagination :paginator="$transactions" />
        </div>
    </div>
</x-admin-layout>
