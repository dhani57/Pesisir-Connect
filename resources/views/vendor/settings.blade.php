<x-vendor-layout :title="'Pengaturan Toko'">
<div class="max-w-4xl mx-auto">
    <h2 class="text-2xl font-bold text-gray-900 mb-6">Pengaturan Toko</h2>

    <form method="POST" action="{{ route('vendor.settings.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf @method('PATCH')

        {{-- Account --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4"><x-heroicon-o-building-storefront class="w-6 h-6 inline-block mr-1.5 -mt-1 text-gray-500"/> Informasi Toko</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2"><label class="block text-sm font-semibold text-gray-700 mb-1">Nama Toko</label><input type="text" name="shop_name" value="{{ old('shop_name', $vendor->shop_name) }}" class="w-full rounded-xl border-gray-300 focus:border-ocean-500 focus:ring-ocean-500" required>@error('shop_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror</div>
                <div><label class="block text-sm font-semibold text-gray-700 mb-1">Jenis Usaha</label><select name="business_type" class="w-full rounded-xl border-gray-300 focus:border-ocean-500 focus:ring-ocean-500"><option value="">Pilih</option>@foreach(['penginapan'=>'Penginapan','kapal'=>'Kapal/Boat','wisata'=>'Paket Wisata','kuliner'=>'Kuliner','lainnya'=>'Lainnya'] as $v=>$l)<option value="{{ $v }}" {{ $vendor->business_type == $v ? 'selected' : '' }}>{{ $l }}</option>@endforeach</select></div>
                <div><label class="block text-sm font-semibold text-gray-700 mb-1">Telepon</label><input type="text" name="phone" value="{{ old('phone', $vendor->phone) }}" class="w-full rounded-xl border-gray-300 focus:border-ocean-500 focus:ring-ocean-500" required></div>
                <div class="md:col-span-2"><label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi</label><textarea name="bio" rows="3" class="w-full rounded-xl border-gray-300 focus:border-ocean-500 focus:ring-ocean-500">{{ old('bio', $vendor->bio) }}</textarea></div>
                <div><label class="block text-sm font-semibold text-gray-700 mb-1">Logo</label>@if($vendor->logo)<img src="{{ asset($vendor->logo) }}" class="w-16 h-16 rounded-xl object-cover mb-2" alt="">@endif<input type="file" name="logo" accept="image/*" class="w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-ocean-50 file:text-ocean-700"></div>
                <div><label class="block text-sm font-semibold text-gray-700 mb-1">Avatar</label>@if($vendor->avatar)<img src="{{ asset($vendor->avatar) }}" class="w-16 h-16 rounded-xl object-cover mb-2" alt="">@endif<input type="file" name="avatar" accept="image/*" class="w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-ocean-50 file:text-ocean-700"></div>
            </div>
        </div>

        {{-- Contact --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4"><x-heroicon-o-map-pin class="w-6 h-6 inline-block mr-1.5 -mt-1 text-gray-500"/> Kontak & Alamat</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2"><label class="block text-sm font-semibold text-gray-700 mb-1">Email (dari akun)</label><input type="email" value="{{ auth()->user()->email }}" class="w-full rounded-xl border-gray-300 bg-gray-50 text-gray-500" disabled></div>
                <div class="md:col-span-2"><label class="block text-sm font-semibold text-gray-700 mb-1">Alamat</label><textarea name="address" rows="2" class="w-full rounded-xl border-gray-300 focus:border-ocean-500 focus:ring-ocean-500">{{ old('address', $vendor->address) }}</textarea></div>
                <div><label class="block text-sm font-semibold text-gray-700 mb-1">Kota</label><input type="text" name="city" value="{{ old('city', $vendor->city) }}" class="w-full rounded-xl border-gray-300 focus:border-ocean-500 focus:ring-ocean-500"></div>
                <div><label class="block text-sm font-semibold text-gray-700 mb-1">Kode Pos</label><input type="text" name="zip_code" value="{{ old('zip_code', $vendor->zip_code) }}" class="w-full rounded-xl border-gray-300 focus:border-ocean-500 focus:ring-ocean-500"></div>
            </div>
        </div>

        {{-- Banking --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4"><x-heroicon-o-building-library class="w-6 h-6 inline-block mr-1.5 -mt-1 text-gray-500"/> Rekening Bank</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div><label class="block text-sm font-semibold text-gray-700 mb-1">Bank</label><input type="text" name="bank_name" value="{{ old('bank_name', $vendor->bank_name) }}" class="w-full rounded-xl border-gray-300 focus:border-ocean-500 focus:ring-ocean-500"></div>
                <div><label class="block text-sm font-semibold text-gray-700 mb-1">Atas Nama</label><input type="text" name="account_holder" value="{{ old('account_holder', $vendor->account_holder) }}" class="w-full rounded-xl border-gray-300 focus:border-ocean-500 focus:ring-ocean-500"></div>
                <div><label class="block text-sm font-semibold text-gray-700 mb-1">No. Rekening</label><input type="text" name="account_number" value="{{ old('account_number', $vendor->account_number) }}" class="w-full rounded-xl border-gray-300 focus:border-ocean-500 focus:ring-ocean-500"></div>
            </div>
        </div>

        {{-- Commission Info --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4"><x-heroicon-o-currency-dollar class="w-5 h-5 inline-block mr-1.5 -mt-1 text-current"/> Komisi & Pendapatan</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-gray-50 rounded-xl p-4"><p class="text-xs text-gray-500 font-medium">Tarif Komisi</p><p class="text-xl font-bold text-gray-900 mt-1">{{ $vendor->effective_commission_rate }}%</p></div>
                <div class="bg-gray-50 rounded-xl p-4"><p class="text-xs text-gray-500 font-medium">Pendapatan Bulan Ini</p><p class="text-xl font-bold text-emerald-600 mt-1">Rp {{ number_format($earningsThisMonth, 0, ',', '.') }}</p></div>
                <div class="bg-gray-50 rounded-xl p-4"><p class="text-xs text-gray-500 font-medium">Total Pendapatan</p><p class="text-xl font-bold text-gray-900 mt-1">{{ $vendor->formatted_earnings }}</p></div>
            </div>
        </div>

        {{-- Preferences --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4"><x-heroicon-o-cog-8-tooth class="w-6 h-6 inline-block mr-1.5 -mt-1 text-gray-500"/> Preferensi</h3>
            <div class="space-y-3">
                <label class="flex items-center gap-3 cursor-pointer"><input type="hidden" name="auto_approve_orders" value="0"><input type="checkbox" name="auto_approve_orders" value="1" class="rounded border-gray-300 text-ocean-600 focus:ring-ocean-500" {{ $vendor->auto_approve_orders ? 'checked' : '' }}><span class="text-sm text-gray-700">Auto-approve pesanan baru</span></label>
                <label class="flex items-center gap-3 cursor-pointer"><input type="hidden" name="enable_notifications" value="0"><input type="checkbox" name="enable_notifications" value="1" class="rounded border-gray-300 text-ocean-600 focus:ring-ocean-500" {{ $vendor->enable_notifications ? 'checked' : '' }}><span class="text-sm text-gray-700">Aktifkan notifikasi</span></label>
            </div>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="flex-1 bg-gradient-to-r from-ocean-500 to-ocean-600 text-white font-bold py-3 px-6 rounded-xl shadow-lg hover:from-ocean-600 hover:to-ocean-700 transition-all">Simpan Pengaturan</button>
            <button type="reset" class="bg-white text-gray-700 font-bold py-3 px-6 rounded-xl border border-gray-300 hover:bg-gray-50 transition-all">Reset</button>
        </div>
    </form>
</div>
</x-vendor-layout>
