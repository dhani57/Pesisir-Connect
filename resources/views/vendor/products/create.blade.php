<x-vendor-layout :title="'Tambah Produk'">
<div class="max-w-4xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('vendor.products.index') }}" class="p-2 rounded-lg hover:bg-gray-100"><svg class="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg></a>
        <h2 class="text-2xl font-bold text-gray-900">Tambah Produk Baru</h2>
    </div>

    <form method="POST" action="{{ route('vendor.products.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @include('vendor.products._form')

        <div class="flex flex-col sm:flex-row gap-3">
            <button type="submit" name="action" value="save" class="flex-1 bg-gradient-to-r from-ocean-500 to-ocean-600 text-white font-bold py-3 px-6 rounded-xl shadow-lg hover:from-ocean-600 hover:to-ocean-700 transition-all">Simpan & Terbitkan</button>
            <button type="submit" name="action" value="save_and_add" class="flex-1 bg-white text-ocean-600 font-bold py-3 px-6 rounded-xl border-2 border-ocean-200 hover:bg-ocean-50 transition-all">Simpan & Tambah Lagi</button>
        </div>
    </form>
</div>
</x-vendor-layout>
