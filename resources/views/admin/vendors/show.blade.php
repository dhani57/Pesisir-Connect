<x-admin-layout title="Detail Vendor">
    <div class="mb-8 flex items-center justify-between">
        <div class="flex items-center gap-x-4">
            <a href="{{ route('admin.vendors.index') }}" class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-white border border-gray-200 text-gray-500 hover:text-gray-700 hover:bg-gray-50 transition-colors shadow-sm">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
            </a>
            <div>
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">Detail Verifikasi Vendor</h2>
                <p class="mt-1 text-sm leading-6 text-gray-500">Tinjau profil usaha vendor secara menyeluruh sebelum memberikan persetujuan.</p>
            </div>
        </div>
        
        <div class="flex items-center gap-x-3">
            <form action="{{ route('admin.vendors.toggle', $vendor) }}" method="POST" class="inline-block">
                @csrf
                @method('PATCH')
                @if($vendor->is_active)
                    <button type="submit" class="inline-flex items-center gap-2 rounded-md bg-white px-3.5 py-2.5 text-sm font-semibold text-rose-600 shadow-sm ring-1 ring-inset ring-rose-200 hover:bg-rose-50 transition-all" onclick="return confirm('Apakah Anda yakin ingin MENCABUT akses vendor ini?')">
                        Revoke Akses
                    </button>
                @else
                    <button type="submit" class="inline-flex items-center gap-2 rounded-md bg-emerald-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-emerald-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600 transition-all">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                        Approve Vendor
                    </button>
                @endif
            </form>
        </div>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div class="mb-6 rounded-xl bg-emerald-50 p-4 border border-emerald-100">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-emerald-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        <!-- Sidebar / User Info -->
        <div class="xl:col-span-1 space-y-6">
            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-200 p-6">
                <div class="text-center">
                    <img class="h-24 w-24 mx-auto rounded-full object-cover shadow-sm ring-4 ring-gray-50" src="https://ui-avatars.com/api/?name={{ urlencode($vendor->name) }}&background=e0f2fe&color=0284c7&size=128" alt="">
                    <h3 class="mt-4 text-lg font-bold text-gray-900">{{ $vendor->name }}</h3>
                    <p class="text-sm text-gray-500">{{ $vendor->email }}</p>
                    
                    <div class="mt-4 flex justify-center">
                        @if($vendor->is_active)
                            <span class="inline-flex items-center rounded-full bg-emerald-50 px-3 py-1 text-sm font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                                Status: Approved
                            </span>
                        @else
                            <span class="inline-flex items-center rounded-full bg-amber-50 px-3 py-1 text-sm font-medium text-amber-700 ring-1 ring-inset ring-amber-600/20">
                                Status: Pending
                            </span>
                        @endif
                    </div>
                </div>

                <div class="mt-6 border-t border-gray-100 pt-6">
                    <dl class="space-y-4">
                        <div class="flex justify-between items-center">
                            <dt class="text-sm font-medium text-gray-500">Terdaftar Sejak</dt>
                            <dd class="text-sm text-gray-900">{{ $vendor->created_at->format('d M Y, H:i') }}</dd>
                        </div>
                        <div class="flex justify-between items-center">
                            <dt class="text-sm font-medium text-gray-500">Peran Akun</dt>
                            <dd class="text-sm text-gray-900 capitalize">{{ $vendor->role }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Main Info -->
        <div class="xl:col-span-2 space-y-6">
            @if($vendor->vendor)
            <!-- Informasi Usaha -->
            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-200 overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-base font-semibold text-gray-900">Informasi Usaha</h3>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Nama Toko / Usaha</dt>
                            <dd class="mt-1 text-base font-semibold text-gray-900">{{ $vendor->vendor->shop_name ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Tipe Bisnis</dt>
                            <dd class="mt-1 text-base font-semibold text-gray-900">{{ $vendor->vendor->business_type ?? '-' }}</dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500">Deskripsi Singkat / Bio</dt>
                            <dd class="mt-1 text-sm text-gray-700 leading-relaxed">{{ $vendor->vendor->bio ?? '-' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Kontak & Alamat -->
            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-200 overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-base font-semibold text-gray-900">Kontak & Alamat</h3>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">No. HP / WhatsApp</dt>
                            <dd class="mt-1 text-base font-medium text-gray-900">{{ $vendor->vendor->phone ?? $vendor->phone ?? '-' }}</dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500">Alamat Lengkap</dt>
                            <dd class="mt-1 text-sm text-gray-700 leading-relaxed">
                                {{ $vendor->vendor->address ?? '-' }}<br>
                                {{ $vendor->vendor->city ?? '-' }}, Kode Pos: {{ $vendor->vendor->zip_code ?? '-' }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Informasi Bank & Legalitas -->
            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-200 overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-base font-semibold text-gray-900">Informasi Finansial & Legalitas</h3>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-6">
                        <div class="p-4 rounded-xl bg-sky-50 border border-sky-100">
                            <dt class="text-sm font-medium text-sky-800">Rekening Pencairan</dt>
                            <dd class="mt-2 text-base font-semibold text-sky-900">{{ $vendor->vendor->bank_name ?? '-' }}</dd>
                            <dd class="mt-1 text-sm text-sky-700">{{ $vendor->vendor->account_number ?? '-' }}</dd>
                            <dd class="text-sm text-sky-700">a.n {{ $vendor->vendor->account_holder ?? '-' }}</dd>
                        </div>
                        <div class="p-4 rounded-xl border border-gray-100 flex flex-col justify-center">
                            <dt class="text-sm font-medium text-gray-500 mb-2">Dokumen Izin Usaha / KTP</dt>
                            <dd>
                                @if($vendor->vendor->business_license)
                                    <a href="{{ Storage::url($vendor->vendor->business_license) }}" target="_blank" class="inline-flex items-center gap-x-2 text-sm font-medium text-white bg-gray-900 hover:bg-gray-800 px-4 py-2 rounded-lg transition-colors shadow-sm w-fit">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                        </svg>
                                        Buka Dokumen
                                    </a>
                                @else
                                    <div class="inline-flex items-center gap-x-2 text-sm text-amber-600 bg-amber-50 px-3 py-2 rounded-lg border border-amber-100 w-fit">
                                        <svg class="h-5 w-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                        Belum ada dokumen
                                    </div>
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
            @else
            <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-200 p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="mt-2 text-sm font-semibold text-gray-900">Data Profil Kosong</h3>
                <p class="mt-1 text-sm text-gray-500">Vendor ini belum melengkapi profil usahanya di platform.</p>
            </div>
            @endif
        </div>
    </div>
</x-admin-layout>
