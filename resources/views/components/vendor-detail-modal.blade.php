@props(['vendor'])

<x-modal name="vendor-detail-{{ $vendor->id }}" maxWidth="2xl">
    <div class="p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold text-gray-900">Detail Verifikasi Vendor</h2>
            <button x-on:click="$dispatch('close-modal', 'vendor-detail-{{ $vendor->id }}')" class="text-gray-400 hover:text-gray-500 transition-colors">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        
        <div class="space-y-6">
            <div class="flex items-center gap-x-4 pb-4 border-b border-gray-100">
                <img class="h-16 w-16 rounded-full object-cover shadow-sm border border-gray-200" src="https://ui-avatars.com/api/?name={{ urlencode($vendor->name) }}&background=e0f2fe&color=0284c7" alt="">
                <div>
                    <h3 class="text-base font-semibold text-gray-900">{{ $vendor->name }}</h3>
                    <p class="text-sm text-gray-500">{{ $vendor->email }}</p>
                </div>
            </div>

            @if($vendor->vendor)
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4">
                <div class="sm:col-span-2 bg-gray-50 p-4 rounded-xl border border-gray-100">
                    <span class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Informasi Usaha</span>
                </div>
                
                <div>
                    <span class="block text-sm font-medium text-gray-500">Nama Toko</span>
                    <span class="block text-sm font-semibold text-gray-900 mt-1">{{ $vendor->vendor->shop_name ?? '-' }}</span>
                </div>
                <div>
                    <span class="block text-sm font-medium text-gray-500">Tipe Bisnis</span>
                    <span class="block text-sm font-semibold text-gray-900 mt-1">{{ $vendor->vendor->business_type ?? '-' }}</span>
                </div>
                <div class="sm:col-span-2">
                    <span class="block text-sm font-medium text-gray-500">Deskripsi Singkat / Bio</span>
                    <span class="block text-sm text-gray-900 mt-1">{{ $vendor->vendor->bio ?? '-' }}</span>
                </div>

                <div class="sm:col-span-2 bg-gray-50 p-4 rounded-xl border border-gray-100 mt-2">
                    <span class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Kontak & Alamat</span>
                </div>
                
                <div>
                    <span class="block text-sm font-medium text-gray-500">No. HP / WhatsApp</span>
                    <span class="block text-sm font-semibold text-gray-900 mt-1">{{ $vendor->vendor->phone ?? $vendor->phone ?? '-' }}</span>
                </div>
                <div class="sm:col-span-2">
                    <span class="block text-sm font-medium text-gray-500">Alamat Lengkap</span>
                    <span class="block text-sm text-gray-900 mt-1">{{ $vendor->vendor->address ?? '-' }}, {{ $vendor->vendor->city ?? '-' }} {{ $vendor->vendor->zip_code ?? '-' }}</span>
                </div>

                <div class="sm:col-span-2 bg-gray-50 p-4 rounded-xl border border-gray-100 mt-2">
                    <span class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Informasi Bank & Legalitas</span>
                </div>
                
                <div>
                    <span class="block text-sm font-medium text-gray-500">Detail Rekening</span>
                    <span class="block text-sm font-semibold text-gray-900 mt-1">{{ $vendor->vendor->bank_name ?? '-' }}</span>
                    <span class="block text-sm text-gray-700">{{ $vendor->vendor->account_number ?? '-' }} a.n {{ $vendor->vendor->account_holder ?? '-' }}</span>
                </div>

                <div>
                    <span class="block text-sm font-medium text-gray-500">Dokumen Izin Usaha / KTP</span>
                    @if($vendor->vendor->business_license)
                    <div class="mt-2">
                        <a href="{{ Storage::url($vendor->vendor->business_license) }}" target="_blank" class="inline-flex items-center gap-x-2 text-sm font-medium text-sky-600 hover:text-sky-700 transition-colors bg-sky-50 px-3 py-1.5 rounded-lg">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                            </svg>
                            Lihat Dokumen
                        </a>
                    </div>
                    @else
                    <span class="block text-sm text-amber-600 mt-1">Belum ada dokumen dilampirkan.</span>
                    @endif
                </div>
            </div>
            @else
            <div class="text-sm text-gray-500 italic bg-gray-50 p-6 rounded-xl text-center border border-gray-100">
                Vendor belum melengkapi data profil usahanya.
            </div>
            @endif
        </div>
        
        <div class="mt-8 flex justify-end border-t border-gray-100 pt-4">
            <button type="button" x-on:click="$dispatch('close-modal', 'vendor-detail-{{ $vendor->id }}')" class="rounded-md bg-white px-4 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 transition-colors">
                Tutup Detail
            </button>
        </div>
    </div>
</x-modal>
