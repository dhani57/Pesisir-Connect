<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-900 leading-tight">
            {{ __('Edit Profil Publik') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="p-6 sm:p-8 bg-white shadow-sm sm:rounded-2xl border border-gray-100">
                <header class="mb-6">
                    <h2 class="text-lg font-bold text-gray-900">Informasi Profil Publik</h2>
                    <p class="mt-1 text-sm text-gray-600">Perbarui informasi profil Anda yang akan ditampilkan ke publik dan vendor.</p>
                </header>

                @if (session('success'))
                    <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-sm font-medium">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="post" action="{{ route('customer.profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('patch')

                    {{-- Avatar --}}
                    <div class="flex items-center gap-6">
                        <div class="shrink-0">
                            <img src="{{ $user->avatar_url }}" alt="Avatar" class="h-20 w-20 object-cover rounded-full border border-gray-200 bg-gray-50">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Foto Profil</label>
                            <input type="file" name="avatar" accept="image/jpeg, image/png, image/webp" 
                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-ocean-50 file:text-ocean-700 hover:file:bg-ocean-100 transition-colors">
                            <p class="mt-1 text-xs text-gray-500">JPG, PNG atau WebP (Maks. 2MB)</p>
                            @error('avatar') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Name --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                               class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-ocean-500 focus:ring-ocean-500 sm:text-sm">
                        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Phone --}}
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">Nomor WhatsApp</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Contoh: 08123456789"
                               class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-ocean-500 focus:ring-ocean-500 sm:text-sm">
                        @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Address --}}
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700">Kota Domisili</label>
                        <input type="text" id="address" name="address" value="{{ old('address', $user->address) }}" placeholder="Contoh: Bandar Lampung"
                               class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-ocean-500 focus:ring-ocean-500 sm:text-sm">
                        @error('address') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Bio --}}
                    <div>
                        <label for="bio" class="block text-sm font-medium text-gray-700">Bio Singkat</label>
                        <textarea id="bio" name="bio" rows="3" placeholder="Ceritakan sedikit tentang Anda..."
                                  class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-ocean-500 focus:ring-ocean-500 sm:text-sm">{{ old('bio', $user->bio) }}</textarea>
                        @error('bio') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center gap-4 pt-4 border-t border-gray-100">
                        <button type="submit" class="btn-primary !py-2">Simpan Perubahan</button>
                        <a href="{{ route('customer.profile.show', $user) }}" class="text-sm text-gray-600 hover:text-ocean-600">Lihat Profil Publik</a>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
</x-app-layout>
