<x-vendor-layout :title="'Produk Saya'">

{{-- Header --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Produk Saya</h2>
        <p class="text-sm text-gray-500 mt-1">Kelola semua produk dan layanan Anda</p>
    </div>
    <a href="{{ route('vendor.products.create') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-ocean-500 to-ocean-600 text-white font-semibold px-5 py-2.5 rounded-xl shadow-sm hover:from-ocean-600 hover:to-ocean-700 transition-all">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
        Tambah Produk
    </a>
</div>

{{-- Filters --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-6">
    <form method="GET" class="flex flex-col sm:flex-row gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau SKU..." class="flex-1 rounded-xl border-gray-300 focus:border-ocean-500 focus:ring-ocean-500 text-sm">
        <select name="status" class="rounded-xl border-gray-300 focus:border-ocean-500 focus:ring-ocean-500 text-sm">
            <option value="">Semua Status</option>
            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
        </select>
        <select name="sort" class="rounded-xl border-gray-300 focus:border-ocean-500 focus:ring-ocean-500 text-sm">
            <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Terbaru</option>
            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nama</option>
            <option value="price" {{ request('sort') == 'price' ? 'selected' : '' }}>Harga</option>
            <option value="stock" {{ request('sort') == 'stock' ? 'selected' : '' }}>Stok</option>
        </select>
        <button type="submit" class="bg-ocean-500 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-ocean-600 transition-colors">Filter</button>
    </form>
</div>

{{-- Products Table --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    @if($products->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-xs text-gray-500 uppercase tracking-wider border-b bg-gray-50/50">
                        <th class="px-4 py-3 text-left">Produk</th>
                        <th class="px-4 py-3 text-left">SKU</th>
                        <th class="px-4 py-3 text-right">Harga</th>
                        <th class="px-4 py-3 text-center">Stok</th>
                        <th class="px-4 py-3 text-center">Status</th>
                        <th class="px-4 py-3 text-left">Tanggal</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($products as $product)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <img src="{{ $product->thumbnail_url }}" class="w-10 h-10 rounded-lg object-cover" alt="">
                                <div>
                                    <p class="font-semibold text-gray-900">{{ Str::limit($product->name, 35) }}</p>
                                    <p class="text-xs text-gray-500">{{ $product->category->name ?? '-' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-gray-600 font-mono text-xs">{{ $product->sku ?? '-' }}</td>
                        <td class="px-4 py-3 text-right font-semibold text-gray-900">{{ $product->formatted_price }}</td>
                        <td class="px-4 py-3 text-center">
                            <span class="{{ $product->stock <= 0 ? 'text-red-600 font-bold' : 'text-gray-700' }}">{{ $product->stock }}</span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ match($product->status) { 'active' => 'bg-emerald-100 text-emerald-700', 'inactive' => 'bg-gray-100 text-gray-600', 'draft' => 'bg-amber-100 text-amber-700', default => 'bg-gray-100 text-gray-600' } }}">
                                {{ match($product->status) { 'active' => 'Aktif', 'inactive' => 'Nonaktif', 'draft' => 'Draft', default => $product->status } }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-gray-500 text-xs">{{ $product->created_at->format('d M Y') }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-center gap-1">
                                <a href="{{ route('vendor.products.edit', $product) }}" class="p-2 rounded-lg hover:bg-ocean-50 text-ocean-600" title="Edit">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form method="POST" action="{{ route('vendor.products.toggle-status', $product) }}" class="inline">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="p-2 rounded-lg hover:bg-amber-50 text-amber-600" title="Toggle Status">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('vendor.products.destroy', $product) }}" class="inline" onsubmit="return confirm('Yakin hapus produk ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 rounded-lg hover:bg-red-50 text-red-600" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100">{{ $products->links() }}</div>
    @else
        <div class="p-12 text-center">
            <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-ocean-50 flex items-center justify-center">
                <svg class="w-8 h-8 text-ocean-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
            <h4 class="text-lg font-bold text-gray-900 mb-2">Belum Ada Produk</h4>
            <p class="text-gray-500 text-sm mb-6">Mulai tambahkan produk atau layanan wisata Anda.</p>
            <a href="{{ route('vendor.products.create') }}" class="inline-flex items-center gap-2 bg-ocean-500 text-white font-semibold px-5 py-2.5 rounded-xl hover:bg-ocean-600 transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                Tambah Produk Pertama
            </a>
        </div>
    @endif
</div>
</x-vendor-layout>
