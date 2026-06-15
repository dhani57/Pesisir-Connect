@php $p = $product ?? null; @endphp

{{-- Basic Info --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
    <h3 class="text-lg font-bold text-gray-900 mb-4"><x-heroicon-o-pencil-square class="w-5 h-5 inline-block mr-1.5 -mt-1 text-current"/> Informasi Dasar</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="md:col-span-2">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Produk <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="{{ old('name', $p->name ?? '') }}" class="w-full rounded-xl border-gray-300 focus:border-ocean-500 focus:ring-ocean-500" required>
            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">SKU / Kode <span class="text-red-500">*</span></label>
            <input type="text" name="sku" value="{{ old('sku', $p->sku ?? '') }}" class="w-full rounded-xl border-gray-300 focus:border-ocean-500 focus:ring-ocean-500" required>
            @error('sku') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Kategori <span class="text-red-500">*</span></label>
            <select name="category_id" class="w-full rounded-xl border-gray-300 focus:border-ocean-500 focus:ring-ocean-500" required>
                <option value="">Pilih Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id', $p->category_id ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
            @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi Singkat (maks. 200 karakter)</label>
            <input type="text" name="short_description" maxlength="200" value="{{ old('short_description', $p->short_description ?? '') }}" class="w-full rounded-xl border-gray-300 focus:border-ocean-500 focus:ring-ocean-500">
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi Lengkap <span class="text-red-500">*</span></label>
            <textarea name="description" rows="5" class="w-full rounded-xl border-gray-300 focus:border-ocean-500 focus:ring-ocean-500" required>{{ old('description', $p->description ?? '') }}</textarea>
            @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
    </div>
</div>

{{-- Pricing & Inventory --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
    <h3 class="text-lg font-bold text-gray-900 mb-4"><x-heroicon-o-currency-dollar class="w-5 h-5 inline-block mr-1.5 -mt-1 text-current"/> Harga & Stok</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Harga (Rp) <span class="text-red-500">*</span></label>
            <input type="number" name="price" value="{{ old('price', $p->price ?? '') }}" min="1" class="w-full rounded-xl border-gray-300 focus:border-ocean-500 focus:ring-ocean-500" required>
            @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Satuan Harga</label>
            <select name="price_unit" class="w-full rounded-xl border-gray-300 focus:border-ocean-500 focus:ring-ocean-500">
                @foreach(['malam' => 'Per Malam', 'jam' => 'Per Jam', 'set' => 'Per Set', 'trip' => 'Per Trip', 'orang' => 'Per Orang'] as $val => $label)
                    <option value="{{ $val }}" {{ old('price_unit', $p->price_unit ?? 'malam') == $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Diskon</label>
            <div class="flex gap-2">
                <input type="number" name="discount" value="{{ old('discount', $p->discount ?? 0) }}" min="0" class="flex-1 rounded-xl border-gray-300 focus:border-ocean-500 focus:ring-ocean-500">
                <select name="discount_type" class="rounded-xl border-gray-300 focus:border-ocean-500 focus:ring-ocean-500 text-sm w-24">
                    <option value="percentage" {{ old('discount_type', $p->discount_type ?? 'percentage') == 'percentage' ? 'selected' : '' }}>%</option>
                    <option value="fixed" {{ old('discount_type', $p->discount_type ?? '') == 'fixed' ? 'selected' : '' }}>Rp</option>
                </select>
            </div>
        </div>
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Stok <span class="text-red-500">*</span></label>
            <input type="number" name="stock" value="{{ old('stock', $p->stock ?? 0) }}" min="0" class="w-full rounded-xl border-gray-300 focus:border-ocean-500 focus:ring-ocean-500" required>
        </div>
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Alert Stok Min.</label>
            <input type="number" name="min_stock_alert" value="{{ old('min_stock_alert', $p->min_stock_alert ?? 10) }}" min="0" class="w-full rounded-xl border-gray-300 focus:border-ocean-500 focus:ring-ocean-500">
        </div>
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Kapasitas</label>
            <input type="number" name="capacity" value="{{ old('capacity', $p->capacity ?? '') }}" min="0" class="w-full rounded-xl border-gray-300 focus:border-ocean-500 focus:ring-ocean-500" placeholder="Tamu/Penumpang">
        </div>
    </div>
</div>

{{-- Location --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
    <h3 class="text-lg font-bold text-gray-900 mb-4"><x-heroicon-o-map-pin class="w-6 h-6 inline-block mr-1.5 -mt-1 text-gray-500"/> Lokasi</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Lokasi <span class="text-red-500">*</span></label>
            <input type="text" name="location" value="{{ old('location', $p->location ?? '') }}" class="w-full rounded-xl border-gray-300 focus:border-ocean-500 focus:ring-ocean-500" placeholder="Pahawang, Krui, dll." required>
        </div>
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat</label>
            <input type="text" name="address" value="{{ old('address', $p->address ?? '') }}" class="w-full rounded-xl border-gray-300 focus:border-ocean-500 focus:ring-ocean-500">
        </div>
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">WhatsApp</label>
            <input type="text" name="whatsapp" value="{{ old('whatsapp', $p->whatsapp ?? '') }}" class="w-full rounded-xl border-gray-300 focus:border-ocean-500 focus:ring-ocean-500" placeholder="08xxxxxxxxxx">
        </div>
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Fasilitas (pisah koma)</label>
            <input type="text" name="facilities" value="{{ old('facilities', is_array($p->facilities ?? null) ? implode(', ', $p->facilities) : ($p->facilities ?? '')) }}" class="w-full rounded-xl border-gray-300 focus:border-ocean-500 focus:ring-ocean-500" placeholder="AC, WiFi, Parkir">
        </div>
    </div>
</div>

{{-- Images --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
    <h3 class="text-lg font-bold text-gray-900 mb-4"><x-heroicon-o-camera class="w-5 h-5 inline-block mr-1.5 -mt-1 text-current"/> Gambar</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Gambar Utama @if(!$p) <span class="text-red-500">*</span> @endif</label>
            @if($p && $p->thumbnail)
                <img src="{{ $p->thumbnail_url }}" class="w-24 h-24 rounded-xl object-cover mb-2" alt="">
            @endif
            <input type="file" name="thumbnail" accept="image/*" class="w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-ocean-50 file:text-ocean-700 hover:file:bg-ocean-100" {{ !$p ? 'required' : '' }}>
            @error('thumbnail') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Galeri (maks. 10 gambar)</label>
            @if($p && $p->gallery)
                <div class="flex gap-2 mb-2">
                    @foreach($p->gallery as $img)
                        <img src="{{ asset($img) }}" class="w-12 h-12 rounded-lg object-cover" alt="">
                    @endforeach
                </div>
            @endif
            <input type="file" name="gallery[]" accept="image/*" multiple class="w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-ocean-50 file:text-ocean-700 hover:file:bg-ocean-100">
        </div>
    </div>
</div>

{{-- Settings & SEO --}}
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
    <h3 class="text-lg font-bold text-gray-900 mb-4"><x-heroicon-o-cog-8-tooth class="w-6 h-6 inline-block mr-1.5 -mt-1 text-gray-500"/> Pengaturan & SEO</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Status</label>
            <select name="status" class="w-full rounded-xl border-gray-300 focus:border-ocean-500 focus:ring-ocean-500">
                <option value="active" {{ old('status', $p->status ?? 'active') == 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="inactive" {{ old('status', $p->status ?? '') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                <option value="draft" {{ old('status', $p->status ?? '') == 'draft' ? 'selected' : '' }}>Draft</option>
            </select>
        </div>
        <div class="flex items-center gap-6 pt-6">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="hidden" name="is_featured" value="0">
                <input type="checkbox" name="is_featured" value="1" class="rounded border-gray-300 text-ocean-600 focus:ring-ocean-500" {{ old('is_featured', $p->is_featured ?? false) ? 'checked' : '' }}>
                <span class="text-sm font-medium text-gray-700">Produk Unggulan</span>
            </label>
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300 text-ocean-600 focus:ring-ocean-500" {{ old('is_active', $p->is_active ?? true) ? 'checked' : '' }}>
                <span class="text-sm font-medium text-gray-700">Tampilkan</span>
            </label>
        </div>
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Meta Title</label>
            <input type="text" name="meta_title" value="{{ old('meta_title', $p->meta_title ?? '') }}" class="w-full rounded-xl border-gray-300 focus:border-ocean-500 focus:ring-ocean-500">
        </div>
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Meta Keywords</label>
            <input type="text" name="meta_keywords" value="{{ old('meta_keywords', $p->meta_keywords ?? '') }}" class="w-full rounded-xl border-gray-300 focus:border-ocean-500 focus:ring-ocean-500">
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Meta Description</label>
            <textarea name="meta_description" rows="2" class="w-full rounded-xl border-gray-300 focus:border-ocean-500 focus:ring-ocean-500">{{ old('meta_description', $p->meta_description ?? '') }}</textarea>
        </div>
    </div>
</div>
