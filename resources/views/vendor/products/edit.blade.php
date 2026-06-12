<x-vendor-layout :title="'Edit Produk'">
<div class="max-w-4xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('vendor.products.index') }}" class="p-2 rounded-lg hover:bg-gray-100"><svg class="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg></a>
        <h2 class="text-2xl font-bold text-gray-900">Edit: {{ $product->name }}</h2>
    </div>

    <form method="POST" action="{{ route('vendor.products.update', $product) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf @method('PUT')
        @include('vendor.products._form', ['product' => $product])

        <button type="submit" class="w-full bg-gradient-to-r from-ocean-500 to-ocean-600 text-white font-bold py-3 px-6 rounded-xl shadow-lg hover:from-ocean-600 hover:to-ocean-700 transition-all">Simpan Perubahan</button>
    </form>
</div>
</x-vendor-layout>
