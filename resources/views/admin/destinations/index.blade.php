<x-admin-layout title="Manajemen Konten Destinasi">
    <!-- Header -->
    <div class="sm:flex sm:items-center sm:justify-between mb-8">
        <div>
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">Manajemen Konten Destinasi</h2>
            <p class="mt-1 text-sm leading-6 text-gray-500">Kelola artikel promosi statis untuk destinasi wisata Pesisir Lampung.</p>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
            <a href="{{ route('admin.destinations.create') }}" class="block rounded-md bg-sky-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-sky-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-600 transition-colors">
                Tambah Destinasi
            </a>
        </div>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div class="mb-4 rounded-xl bg-emerald-50 p-4 border border-emerald-100">
            <div class="flex">
                <div class="ml-3">
                    <p class="text-sm font-medium text-emerald-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Table -->
    <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-16">No.</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Destinasi</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Deskripsi & Tagline</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tags / Lokasi</th>
                        <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse($destinations as $destination)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500 font-medium align-top">
                                {{ $destinations->firstItem() + $loop->index }}
                            </td>
                            <td class="px-6 py-4 align-top">
                                <div class="flex items-start">
                                    <div class="h-16 w-24 flex-shrink-0 mt-1">
                                        @if($destination->image)
                                            <img class="h-16 w-24 rounded-lg object-cover shadow-sm" src="{{ asset($destination->image) }}" alt="{{ $destination->name }}">
                                        @else
                                            <div class="h-16 w-24 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400">
                                                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="font-medium text-gray-900 text-base">{{ $destination->name }}</div>
                                        @if($destination->rating > 0)
                                            <div class="flex items-center mt-1 text-sm text-amber-500">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                <span class="font-semibold text-gray-700">{{ $destination->rating }}</span>
                                                <span class="text-gray-400 ml-1">({{ $destination->reviews_count }})</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 align-top">
                                <div class="text-sm font-semibold text-sky-600 mb-1">"{{ $destination->tagline ?: 'Tidak ada tagline' }}"</div>
                                <div class="text-sm text-gray-500 line-clamp-2 max-w-xs" title="{{ $destination->description }}">
                                    {{ Str::limit($destination->description, 100) }}
                                </div>
                            </td>
                            <td class="px-6 py-4 align-top max-w-xs">
                                <div class="flex items-center text-sm text-gray-600 mb-3">
                                    <svg class="w-4 h-4 mr-1.5 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    <span class="truncate">{{ $destination->location }}</span>
                                </div>
                                @if($destination->highlights && count($destination->highlights) > 0)
                                    <div class="flex flex-wrap gap-1.5">
                                        @foreach($destination->highlights as $tag)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">
                                                {{ $tag }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium align-top">
                                <a href="{{ route('admin.destinations.edit', $destination) }}" class="text-sky-600 hover:text-sky-900 mr-4">Edit</a>
                                <form action="{{ route('admin.destinations.destroy', $destination) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus konten destinasi ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-600 hover:text-rose-900">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-sm text-gray-500">
                                Belum ada konten destinasi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($destinations->hasPages())
            <div class="border-t border-gray-200 px-6 py-4">
                {{ $destinations->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>
