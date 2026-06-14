@props(['paginator'])

@php
    $perPageOptions = [10, 25, 50, 100, 'all'];
    $currentPerPage = request('per_page', 10);
@endphp

<div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6 mt-4 rounded-b-xl shadow-sm ring-1 ring-gray-200">
    <div class="flex items-center text-sm text-gray-500">
        <label for="per_page_{{ md5(url()->current()) }}" class="mr-2 font-medium">Tampilkan:</label>
        <select 
            id="per_page_{{ md5(url()->current()) }}" 
            name="per_page" 
            class="rounded-md border-gray-300 py-1.5 pl-3 pr-8 text-sm focus:ring-sky-500 focus:border-sky-500 shadow-sm"
            onchange="window.location.href = '?per_page=' + this.value + '{{ request()->has('search') ? '&search=' . request('search') : '' }}'"
        >
            @foreach($perPageOptions as $option)
                <option value="{{ $option }}" {{ (string) $currentPerPage === (string) $option ? 'selected' : '' }}>
                    {{ $option === 'all' ? 'Semua' : $option }}
                </option>
            @endforeach
        </select>
        <span class="ml-2 hidden sm:inline-block">item per halaman</span>
    </div>

    <div class="flex items-center">
        @if($currentPerPage !== 'all')
            {{ $paginator->appends(request()->query())->links() }}
        @else
            <span class="text-sm text-gray-700">
                Menampilkan seluruh <span class="font-medium">{{ $paginator->total() }}</span> hasil
            </span>
        @endif
    </div>
</div>
