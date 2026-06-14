<x-admin-layout>
    <x-slot:title>Pengaturan Global</x-slot:title>
    
    <div class="mb-8">
        <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
            Pengaturan Sistem
        </h2>
        <p class="mt-2 text-sm text-gray-600">
            Konfigurasi parameter utama platform PesisirConnect.
        </p>
    </div>

    @if(session('success'))
        <div class="mb-4 rounded-md bg-green-50 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <div x-data="{ activeTab: 'financial' }">
        <div class="sm:hidden">
            <label for="tabs" class="sr-only">Pilih tab pengaturan</label>
            <select id="tabs" name="tabs" x-model="activeTab" class="block w-full rounded-md border-gray-300 focus:border-sky-500 focus:ring-sky-500">
                <option value="financial">Finansial & Komisi</option>
                <option value="contact">Informasi Kontak</option>
                <option value="social">Media Sosial</option>
            </select>
        </div>
        <div class="hidden sm:block">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                    <button @click="activeTab = 'financial'" :class="activeTab === 'financial' ? 'border-sky-500 text-sky-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'" class="whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                        Finansial & Komisi
                    </button>
                    <button @click="activeTab = 'contact'" :class="activeTab === 'contact' ? 'border-sky-500 text-sky-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'" class="whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                        Informasi Kontak
                    </button>
                    <button @click="activeTab = 'social'" :class="activeTab === 'social' ? 'border-sky-500 text-sky-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'" class="whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                        Media Sosial
                    </button>
                </nav>
            </div>
        </div>

        <form action="{{ route('admin.settings.update') }}" method="POST" class="mt-6">
            @csrf

            <!-- Finansial Tab -->
            <div x-show="activeTab === 'financial'" class="space-y-6">
                <div class="bg-white px-4 py-5 shadow sm:rounded-lg sm:p-6">
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-1">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Komisi Platform</h3>
                            <p class="mt-1 text-sm text-gray-500">Persentase potongan default untuk setiap transaksi.</p>
                        </div>
                        <div class="mt-5 space-y-6 md:col-span-2 md:mt-0">
                            <div>
                                <label for="platform_commission" class="block text-sm font-medium leading-6 text-gray-900">Persentase Komisi (%)</label>
                                <div class="relative mt-2 rounded-md shadow-sm sm:max-w-xs">
                                    <input type="number" name="platform_commission" id="platform_commission" value="{{ setting('platform_commission', '5') }}" class="block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm sm:leading-6" placeholder="5" step="0.01">
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                        <span class="text-gray-500 sm:text-sm">%</span>
                                    </div>
                                </div>
                                <p class="mt-2 text-sm text-gray-500">Nilai ini digunakan jika vendor tidak memiliki tarif komisi spesifik.</p>
                            </div>

                            <div>
                                <label for="minimum_payout" class="block text-sm font-medium leading-6 text-gray-900">Batas Minimum Pencairan (Rp)</label>
                                <div class="relative mt-2 rounded-md shadow-sm sm:max-w-md">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <span class="text-gray-500 sm:text-sm">Rp</span>
                                    </div>
                                    <input type="number" name="minimum_payout" id="minimum_payout" value="{{ setting('minimum_payout', '50000') }}" class="block w-full rounded-md border-0 py-1.5 pl-10 pr-12 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm sm:leading-6" placeholder="50000">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kontak Tab -->
            <div x-show="activeTab === 'contact'" x-cloak class="space-y-6">
                <div class="bg-white px-4 py-5 shadow sm:rounded-lg sm:p-6">
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-1">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Kontak Resmi</h3>
                            <p class="mt-1 text-sm text-gray-500">Informasi ini akan ditampilkan di halaman utama dan halaman bantuan.</p>
                        </div>
                        <div class="mt-5 space-y-6 md:col-span-2 md:mt-0">
                            <div>
                                <label for="support_email" class="block text-sm font-medium leading-6 text-gray-900">Email Bantuan</label>
                                <div class="mt-2">
                                    <input type="email" name="support_email" id="support_email" value="{{ setting('support_email', 'cs@pesisirconnect.com') }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:max-w-md sm:text-sm sm:leading-6">
                                </div>
                            </div>

                            <div>
                                <label for="support_whatsapp" class="block text-sm font-medium leading-6 text-gray-900">Nomor WhatsApp CS</label>
                                <div class="mt-2">
                                    <input type="text" name="support_whatsapp" id="support_whatsapp" value="{{ setting('support_whatsapp', '081234567890') }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:max-w-md sm:text-sm sm:leading-6">
                                </div>
                                <p class="mt-2 text-sm text-gray-500">Gunakan format 08... atau 628...</p>
                            </div>

                            <div>
                                <label for="office_address" class="block text-sm font-medium leading-6 text-gray-900">Alamat Kantor</label>
                                <div class="mt-2">
                                    <textarea id="office_address" name="office_address" rows="3" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm sm:leading-6">{{ setting('office_address', 'Jl. Pantai No. 1, Pesisir Barat, Lampung') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sosial Tab -->
            <div x-show="activeTab === 'social'" x-cloak class="space-y-6">
                <div class="bg-white px-4 py-5 shadow sm:rounded-lg sm:p-6">
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-1">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Jejaring Sosial</h3>
                            <p class="mt-1 text-sm text-gray-500">Tautan lengkap menuju halaman media sosial resmi platform.</p>
                        </div>
                        <div class="mt-5 space-y-6 md:col-span-2 md:mt-0">
                            <div>
                                <label for="social_instagram" class="block text-sm font-medium leading-6 text-gray-900">Instagram URL</label>
                                <div class="mt-2">
                                    <input type="url" name="social_instagram" id="social_instagram" value="{{ setting('social_instagram', 'https://instagram.com/pesisirconnect') }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:max-w-md sm:text-sm sm:leading-6">
                                </div>
                            </div>

                            <div>
                                <label for="social_facebook" class="block text-sm font-medium leading-6 text-gray-900">Facebook URL</label>
                                <div class="mt-2">
                                    <input type="url" name="social_facebook" id="social_facebook" value="{{ setting('social_facebook', 'https://facebook.com/pesisirconnect') }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:max-w-md sm:text-sm sm:leading-6">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-6 flex items-center justify-end gap-x-6">
                <button type="submit" class="rounded-md bg-sky-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-sky-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-600 transition-all">
                    Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
