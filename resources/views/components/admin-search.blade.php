@props(['placeholder' => 'Cari...'])

<div class="mb-4 sm:mb-0 sm:w-72">
    <form x-data action="{{ url()->current() }}" method="GET" class="relative flex items-center">
        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
            </svg>
        </div>
        <input 
            x-init="if($el.value) { setTimeout(() => { $el.focus(); $el.setSelectionRange($el.value.length, $el.value.length); }, 50) }"
            type="text" 
            name="search" 
            value="{{ request('search') }}" 
            class="block w-full rounded-md border-0 py-2 pl-10 pr-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm sm:leading-6 transition-all" 
            placeholder="{{ $placeholder }}"
            @input.debounce.500ms="$el.form.submit()"
        >
        
        <!-- Pertahankan parameter query lainnya (seperti per_page) -->
        @foreach(request()->except(['search', 'page']) as $key => $value)
            @if(is_array($value))
                @foreach($value as $v)
                    <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
                @endforeach
            @else
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endif
        @endforeach
    </form>
</div>
