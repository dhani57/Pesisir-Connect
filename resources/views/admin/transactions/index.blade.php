<x-admin-layout title="Audit Finansial Global">
    <!-- Header -->
    <div class="sm:flex sm:items-center sm:justify-between mb-8">
        <div>
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">Audit Finansial Global</h2>
            <p class="mt-1 text-sm leading-6 text-gray-500">Memantau seluruh arus kas masuk dari transaksi produk milik semua vendor.</p>
        </div>
        <div class="mt-4 sm:mt-0 flex items-center gap-3">
            <a href="{{ route('admin.transactions.export', request()->query()) }}" class="inline-flex items-center gap-1.5 rounded-lg bg-white px-3 py-2 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
                Export CSV
            </a>
        </div>
    </div>

    <!-- Status Summary Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl border border-gray-200 p-4">
            <div class="text-xs font-semibold text-gray-500 uppercase">Total</div>
            <div class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($statusCounts['total']) }}</div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-4">
            <div class="text-xs font-semibold text-emerald-600 uppercase">Dibayar</div>
            <div class="text-2xl font-bold text-emerald-700 mt-1">{{ number_format($statusCounts['paid']) }}</div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-4">
            <div class="text-xs font-semibold text-amber-600 uppercase">Pending</div>
            <div class="text-2xl font-bold text-amber-700 mt-1">{{ number_format($statusCounts['pending']) }}</div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-4">
            <div class="text-xs font-semibold text-rose-600 uppercase">Dibatalkan</div>
            <div class="text-2xl font-bold text-rose-700 mt-1">{{ number_format($statusCounts['cancelled']) }}</div>
        </div>
    </div>

    <!-- Filters -->
    <form method="GET" action="{{ route('admin.transactions.index') }}" class="bg-white rounded-xl border border-gray-200 p-4 mb-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
            <!-- Search -->
            <div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari invoice, customer, produk..." class="w-full rounded-lg border-gray-300 text-sm focus:border-sky-500 focus:ring-sky-500">
            </div>
            <!-- Status -->
            <div>
                <select name="status" class="w-full rounded-lg border-gray-300 text-sm focus:border-sky-500 focus:ring-sky-500">
                    <option value="">Semua Status</option>
                    <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Dibayar</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    <option value="refunded" {{ request('status') === 'refunded' ? 'selected' : '' }}>Refunded</option>
                </select>
            </div>
            <!-- Vendor Status -->
            <div>
                <select name="vendor_status" class="w-full rounded-lg border-gray-300 text-sm focus:border-sky-500 focus:ring-sky-500">
                    <option value="">Semua Status Vendor</option>
                    <option value="pending" {{ request('vendor_status') === 'pending' ? 'selected' : '' }}>Menunggu</option>
                    <option value="ready" {{ request('vendor_status') === 'ready' ? 'selected' : '' }}>Siap</option>
                    <option value="completed" {{ request('vendor_status') === 'completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="cancelled" {{ request('vendor_status') === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>
            <!-- Date From -->
            <div>
                <input type="date" name="date_from" value="{{ request('date_from') }}" placeholder="Dari tanggal" class="w-full rounded-lg border-gray-300 text-sm focus:border-sky-500 focus:ring-sky-500">
            </div>
            <!-- Date To + Submit -->
            <div class="flex gap-2">
                <input type="date" name="date_to" value="{{ request('date_to') }}" placeholder="Sampai tanggal" class="flex-1 rounded-lg border-gray-300 text-sm focus:border-sky-500 focus:ring-sky-500">
                <button type="submit" class="px-4 py-2 bg-sky-600 text-white text-sm font-semibold rounded-lg hover:bg-sky-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
                </button>
            </div>
        </div>
        @if(request()->hasAny(['search', 'status', 'vendor_status', 'date_from', 'date_to']))
            <div class="mt-3">
                <a href="{{ route('admin.transactions.index') }}" class="text-xs text-sky-600 hover:text-sky-700 font-medium">✕ Reset filter</a>
            </div>
        @endif
    </form>

    <!-- Transactions Container -->
    <div id="table-container" class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

        <!-- Mobile Card View -->
        <div class="block sm:hidden divide-y divide-gray-200">
            @forelse($transactions as $trx)
                <a href="{{ route('admin.transactions.show', $trx) }}" class="block p-4 hover:bg-gray-50 transition-colors">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-gray-900">{{ $trx->invoice_number }}</span>
                        @if($trx->status === 'paid')
                            <span class="inline-flex items-center rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/20">Dibayar</span>
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
                        Vendor: {{ $trx->product?->vendor?->user?->name ?? '-' }}
                    </div>
                    <div class="flex items-center justify-between border-t border-gray-100 pt-2 mt-2">
                        <span class="text-xs text-gray-500">{{ $trx->created_at->format('d M Y H:i') }}</span>
                        <span class="font-bold text-gray-900">{{ $trx->formatted_total }}</span>
                    </div>
                </a>
            @empty
                <div class="p-8 text-center text-sm text-gray-500">
                    Tidak ada transaksi yang cocok dengan filter.
                </div>
            @endforelse
        </div>

        <!-- Desktop Table View -->
        <div class="hidden sm:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-16">No.</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Invoice & Tgl</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Customer</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Produk & Vendor</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Total</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse($transactions as $trx)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 font-medium">
                                {{ $transactions->firstItem() + $loop->index }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <a href="{{ route('admin.transactions.show', $trx) }}" class="font-medium text-sky-600 hover:text-sky-700">{{ $trx->invoice_number }}</a>
                                <div class="text-xs text-gray-500">{{ $trx->created_at->format('d M Y H:i') }}</div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="font-medium text-gray-900">{{ $trx->customer->name ?? 'Guest' }}</div>
                                <div class="text-xs text-gray-500">{{ $trx->customer->email ?? '-' }}</div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="font-medium text-gray-900">{{ Str::limit($trx->product->name ?? 'Produk Dihapus', 25) }}</div>
                                <div class="text-xs text-gray-500">{{ $trx->product?->vendor?->user?->name ?? '-' }}</div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="font-bold text-gray-900">{{ $trx->formatted_total }}</div>
                                @if($trx->payment_method)
                                    <div class="text-xs text-gray-500 uppercase">{{ $trx->payment_method }}</div>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                @if($trx->status === 'paid')
                                    <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/20">Dibayar</span>
                                @elseif($trx->status === 'pending')
                                    <span class="inline-flex items-center rounded-full bg-amber-50 px-2.5 py-0.5 text-xs font-medium text-amber-700 ring-1 ring-inset ring-amber-600/20">Pending</span>
                                @elseif($trx->status === 'refunded')
                                    <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-600/20">Refunded</span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-rose-50 px-2.5 py-0.5 text-xs font-medium text-rose-700 ring-1 ring-inset ring-rose-600/20">{{ ucfirst($trx->status) }}</span>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-center">
                                <a href="{{ route('admin.transactions.show', $trx) }}" class="inline-flex items-center gap-1 rounded-lg px-2.5 py-1.5 text-xs font-semibold text-sky-600 hover:text-sky-700 hover:bg-sky-50 transition-colors">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-10 text-center text-sm text-gray-500">
                                Tidak ada transaksi yang cocok dengan filter.
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
