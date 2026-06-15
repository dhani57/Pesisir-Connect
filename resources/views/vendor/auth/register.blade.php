<x-app-layout>
<div class="min-h-screen flex items-center justify-center py-12 px-4">
    <div class="max-w-2xl w-full">
        <div class="text-center mb-8">
            <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-gradient-to-br from-ocean-500 to-ocean-700 flex items-center justify-center shadow-lg">
                <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">Daftar Sebagai Vendor</h1>
            <p class="text-gray-500 mt-2">Mulai jual layanan wisata Anda di PesisirConnect</p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
            <form method="POST" action="{{ route('vendor.register') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf

                {{-- Shop Info --}}
                <div class="border-b pb-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4"><x-heroicon-o-building-storefront class="w-6 h-6 inline-block mr-1.5 -mt-1 text-gray-500"/> Informasi Toko</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Toko <span class="text-red-500">*</span></label>
                            <input type="text" name="shop_name" value="{{ old('shop_name') }}" class="w-full rounded-xl border-gray-300 focus:border-ocean-500 focus:ring-ocean-500" required>
                            @error('shop_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor Telepon <span class="text-red-500">*</span></label>
                            <input type="text" name="phone" value="{{ old('phone') }}" class="w-full rounded-xl border-gray-300 focus:border-ocean-500 focus:ring-ocean-500" placeholder="08xxxxxxxxxx" required>
                            @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Jenis Usaha</label>
                            <select name="business_type" class="w-full rounded-xl border-gray-300 focus:border-ocean-500 focus:ring-ocean-500">
                                <option value="">Pilih jenis usaha</option>
                                <option value="penginapan" {{ old('business_type') == 'penginapan' ? 'selected' : '' }}>Penginapan / Homestay</option>
                                <option value="kapal" {{ old('business_type') == 'kapal' ? 'selected' : '' }}>Kapal / Boat</option>
                                <option value="wisata" {{ old('business_type') == 'wisata' ? 'selected' : '' }}>Paket Wisata</option>
                                <option value="kuliner" {{ old('business_type') == 'kuliner' ? 'selected' : '' }}>Kuliner</option>
                                <option value="lainnya" {{ old('business_type') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi Toko</label>
                        <textarea name="bio" rows="3" class="w-full rounded-xl border-gray-300 focus:border-ocean-500 focus:ring-ocean-500" placeholder="Ceritakan tentang usaha Anda...">{{ old('bio') }}</textarea>
                    </div>
                </div>

                {{-- Address --}}
                <div class="border-b pb-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4"><x-heroicon-o-map-pin class="w-6 h-6 inline-block mr-1.5 -mt-1 text-gray-500"/> Alamat</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat Lengkap</label>
                            <textarea name="address" rows="2" class="w-full rounded-xl border-gray-300 focus:border-ocean-500 focus:ring-ocean-500">{{ old('address') }}</textarea>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Kota / Kabupaten</label>
                                <input type="text" name="city" value="{{ old('city') }}" class="w-full rounded-xl border-gray-300 focus:border-ocean-500 focus:ring-ocean-500">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Kode Pos</label>
                                <input type="text" name="zip_code" value="{{ old('zip_code') }}" class="w-full rounded-xl border-gray-300 focus:border-ocean-500 focus:ring-ocean-500">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Bank Info --}}
                <div class="border-b pb-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4"><x-heroicon-o-building-library class="w-6 h-6 inline-block mr-1.5 -mt-1 text-gray-500"/> Informasi Rekening</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Bank</label>
                            <input type="text" name="bank_name" value="{{ old('bank_name') }}" class="w-full rounded-xl border-gray-300 focus:border-ocean-500 focus:ring-ocean-500" placeholder="BCA, BRI, dll.">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Atas Nama</label>
                            <input type="text" name="account_holder" value="{{ old('account_holder') }}" class="w-full rounded-xl border-gray-300 focus:border-ocean-500 focus:ring-ocean-500">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor Rekening</label>
                            <input type="text" name="account_number" value="{{ old('account_number') }}" class="w-full rounded-xl border-gray-300 focus:border-ocean-500 focus:ring-ocean-500">
                        </div>
                    </div>
                </div>

                {{-- Files --}}
                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-4"><x-heroicon-o-paper-clip class="w-6 h-6 inline-block mr-1.5 -mt-1 text-gray-500"/> Dokumen</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Logo Toko</label>
                            <input type="file" name="logo" accept="image/*" class="w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-ocean-50 file:text-ocean-700 hover:file:bg-ocean-100">
                            @error('logo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Izin Usaha (opsional)</label>
                            <input type="file" name="business_license" accept="image/*,.pdf" class="w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-ocean-50 file:text-ocean-700 hover:file:bg-ocean-100">
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-ocean-500 to-ocean-600 text-white font-bold py-3 px-6 rounded-xl shadow-lg hover:from-ocean-600 hover:to-ocean-700 transition-all duration-200 active:scale-[0.98]">
                    Daftar Sebagai Vendor
                </button>
            </form>
        </div>
    </div>
</div>
</x-app-layout>
