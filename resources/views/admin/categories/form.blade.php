<x-admin-layout title="{{ isset($category) ? 'Edit Kategori' : 'Tambah Kategori' }}">
    <div class="mb-8">
        <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
            {{ isset($category) ? 'Edit Kategori' : 'Tambah Kategori' }}
        </h2>
        <p class="mt-1 text-sm leading-6 text-gray-500">Isi form berikut untuk mengelola kategori wisata.</p>
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

    <form action="{{ isset($category) ? route('admin.categories.update', $category) : route('admin.categories.store') }}" method="POST" class="bg-white shadow-sm ring-1 ring-gray-200 sm:rounded-2xl md:col-span-2">
        @csrf
        @if(isset($category))
            @method('PUT')
        @endif

        <div class="px-4 py-6 sm:p-8">
            <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                
                <div class="sm:col-span-4">
                    <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Nama Kategori <span class="text-rose-500">*</span></label>
                    <div class="mt-2">
                        <input type="text" name="name" id="name" value="{{ old('name', $category->name ?? '') }}" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm sm:leading-6">
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label for="icon" class="block text-sm font-medium leading-6 text-gray-900">Ikon (Emoji)</label>
                    <div class="mt-2">
                        <input type="text" name="icon" id="icon" value="{{ old('icon', $category->icon ?? '🏖️') }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm sm:leading-6">
                    </div>
                </div>

                <div class="col-span-full">
                    <label for="description" class="block text-sm font-medium leading-6 text-gray-900">Deskripsi</label>
                    <div class="mt-2">
                        <textarea id="description" name="description" rows="3" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm sm:leading-6">{{ old('description', $category->description ?? '') }}</textarea>
                    </div>
                </div>

                <div class="col-span-full">
                    <div class="relative flex items-start">
                        <div class="flex h-6 items-center">
                            <input id="is_active" name="is_active" type="checkbox" value="1" {{ old('is_active', $category->is_active ?? true) ? 'checked' : '' }} class="h-4 w-4 rounded border-gray-300 text-sky-600 focus:ring-sky-600">
                        </div>
                        <div class="ml-3 text-sm leading-6">
                            <label for="is_active" class="font-medium text-gray-900">Aktifkan Kategori</label>
                            <p class="text-gray-500">Kategori yang tidak aktif tidak akan ditampilkan di halaman depan.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="flex items-center justify-end gap-x-6 border-t border-gray-100 bg-gray-50/50 px-4 py-4 sm:px-8 rounded-b-2xl">
            <a href="{{ route('admin.categories.index') }}" class="text-sm font-semibold leading-6 text-gray-900 hover:text-gray-700">Batal</a>
            <button type="submit" class="rounded-md bg-sky-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-sky-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-600 transition-colors">
                Simpan Kategori
            </button>
        </div>
    </form>
</x-admin-layout>
