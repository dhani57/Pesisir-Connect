@props(['placeholder' => 'Cari...'])

<div class="mb-4 sm:mb-0 sm:w-72" x-data="{
    query: '{{ request('search') }}',
    isLoading: false,
    abortController: null,
    search() {
        this.isLoading = true;
        let url = new URL(window.location.href);
        if (this.query.trim() !== '') {
            url.searchParams.set('search', this.query);
        } else {
            url.searchParams.delete('search');
        }
        url.searchParams.delete('page');
        
        // Perbarui URL browser tanpa memenuhi history (replaceState)
        window.history.replaceState({}, '', url);

        // Batalkan request AJAX sebelumnya jika ada, agar tidak terjadi antrean/session lock
        if (this.abortController) {
            this.abortController.abort();
        }
        this.abortController = new AbortController();

        // Ambil data tabel terbaru via AJAX
        fetch(url, { 
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            signal: this.abortController.signal
        })
            .then(res => res.text())
            .then(html => {
                let parser = new DOMParser();
                let doc = parser.parseFromString(html, 'text/html');
                let newTable = doc.getElementById('table-container');
                if (newTable) {
                    document.getElementById('table-container').innerHTML = newTable.innerHTML;
                }
            })
            .catch(error => {
                if (error.name === 'AbortError') return;
                console.error('Search error:', error);
            })
            .finally(() => {
                this.isLoading = false;
            });
    },
    init() {
        window.addEventListener('beforeunload', () => {
            if (this.abortController) this.abortController.abort();
        });
    }
}">
    <form @submit.prevent="search" class="relative flex items-center">
        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
            <svg x-show="!isLoading" class="h-5 w-5 text-gray-400 transition-opacity" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
            </svg>
            <svg x-show="isLoading" style="display: none;" class="h-5 w-5 text-sky-500 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>
        <input 
            type="text" 
            x-model="query"
            @input.debounce.400ms="search"
            autocomplete="off"
            class="block w-full rounded-md border-0 py-2 pl-10 pr-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm sm:leading-6 transition-all" 
            placeholder="{{ $placeholder }}"
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
