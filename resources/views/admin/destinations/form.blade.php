<x-admin-layout title="{{ isset($destination) ? 'Edit Destinasi' : 'Tambah Destinasi' }}">
    <div class="mb-8">
        <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
            {{ isset($destination) ? 'Edit Destinasi' : 'Tambah Destinasi' }}
        </h2>
        <p class="mt-1 text-sm leading-6 text-gray-500">Isi form berikut untuk mengelola konten promosi destinasi wisata.</p>
    </div>

    <!-- Error -->
    @if($errors->any())
        <div class="mb-4 rounded-xl bg-rose-50 p-4 border border-rose-100">
            <div class="flex">
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-rose-800">Terdapat kesalahan:</h3>
                    <div class="mt-2 text-sm text-rose-700">
                        <ul role="list" class="list-disc space-y-1 pl-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <form action="{{ isset($destination) ? route('admin.destinations.update', $destination) : route('admin.destinations.store') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-sm ring-1 ring-gray-200 sm:rounded-2xl md:col-span-2">
        @csrf
        @if(isset($destination))
            @method('PUT')
        @endif

        <div class="px-4 py-6 sm:p-8">
            <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                
                <div class="sm:col-span-3">
                    <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Nama Tempat <span class="text-rose-500">*</span></label>
                    <div class="mt-2">
                        <input type="text" name="name" id="name" value="{{ old('name', $destination->name ?? '') }}" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm sm:leading-6">
                    </div>
                </div>

                <div class="sm:col-span-3">
                    <label for="location" class="block text-sm font-medium leading-6 text-gray-900">Lokasi / Daerah <span class="text-rose-500">*</span></label>
                    <div class="mt-2">
                        <input type="text" name="location" id="location" value="{{ old('location', $destination->location ?? '') }}" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm sm:leading-6" placeholder="Contoh: Pesawaran, Lampung">
                    </div>
                </div>

                <div class="sm:col-span-3">
                    <label for="tagline" class="block text-sm font-medium leading-6 text-gray-900">Tagline</label>
                    <div class="mt-2">
                        <input type="text" name="tagline" id="tagline" value="{{ old('tagline', $destination->tagline ?? '') }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm sm:leading-6" placeholder="Contoh: Surga Snorkeling Lampung">
                    </div>
                </div>

                <div class="sm:col-span-3">
                    <label for="sort_order" class="block text-sm font-medium leading-6 text-gray-900">Urutan Tampil</label>
                    <div class="mt-2">
                        <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $destination->sort_order ?? 0) }}" min="0" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm sm:leading-6">
                    </div>
                </div>

                <div class="col-span-full">
                    <label for="image" class="block text-sm font-medium leading-6 text-gray-900">Foto Cover</label>
                    <div class="mt-2 flex items-center gap-x-3">
                        @if(isset($destination) && $destination->image)
                            <img src="{{ $destination->image_url }}" alt="Preview" class="h-20 w-32 object-cover rounded-lg shadow-sm border border-gray-200">
                        @endif
                        <input type="file" name="image" id="image" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100">
                    </div>
                </div>

                <div class="sm:col-span-3">
                    <label for="rating" class="block text-sm font-medium leading-6 text-gray-900">Rating (0.0 - 5.0)</label>
                    <div class="mt-2">
                        <input type="number" step="0.1" min="0" max="5" name="rating" id="rating" value="{{ old('rating', $destination->rating ?? '0.0') }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm sm:leading-6">
                    </div>
                </div>

                <div class="sm:col-span-3">
                    <label for="reviews_count" class="block text-sm font-medium leading-6 text-gray-900">Jumlah Review</label>
                    <div class="mt-2">
                        <input type="number" min="0" name="reviews_count" id="reviews_count" value="{{ old('reviews_count', $destination->reviews_count ?? '0') }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm sm:leading-6">
                    </div>
                </div>

                <div class="col-span-full">
                    <label for="description" class="block text-sm font-medium leading-6 text-gray-900">Deskripsi Konten Promosi <span class="text-rose-500">*</span></label>
                    <div class="mt-2">
                        <textarea id="description" name="description" rows="5" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm sm:leading-6">{{ old('description', $destination->description ?? '') }}</textarea>
                    </div>
                </div>

                <div class="col-span-full">
                    <label for="highlights" class="block text-sm font-medium leading-6 text-gray-900">Highlights / Keunggulan</label>
                    <p class="text-xs text-gray-500 mt-1">Pisahkan tiap poin highlight dengan baris baru (Enter).</p>
                    <div class="mt-2">
                        <textarea id="highlights" name="highlights" rows="4" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm sm:leading-6">{{ old('highlights', isset($destination) && is_array($destination->highlights) ? implode("\n", $destination->highlights) : '') }}</textarea>
                    </div>
                </div>

                <div class="sm:col-span-3">
                    <label class="flex items-center gap-3">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $destination->is_active ?? true) ? 'checked' : '' }} class="rounded border-gray-300 text-sky-600 focus:ring-sky-600">
                        <span class="text-sm font-medium text-gray-900">Aktif (tampil di halaman depan)</span>
                    </label>
                </div>

            </div>
        </div>
        <div class="flex items-center justify-end gap-x-6 border-t border-gray-100 bg-gray-50/50 px-4 py-4 sm:px-8 rounded-b-2xl">
            <a href="{{ route('admin.destinations.index') }}" class="text-sm font-semibold leading-6 text-gray-900 hover:text-gray-700">Batal</a>
            <button type="submit" class="rounded-md bg-sky-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-sky-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-600 transition-colors">
                Simpan Destinasi
            </button>
        </div>
    </form>
</x-admin-layout>
