<x-filament-widgets::widget>
    <div class="bg-gradient-to-br from-sky-500 to-sky-700 rounded-2xl shadow-lg overflow-hidden relative mb-6">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
        <div class="relative p-8 sm:p-10 text-white flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
            <div>
                <h3 class="text-3xl font-bold mb-2">Halo, {{ filament()->auth()->user()->name }}! 👋</h3>
                <p class="text-sky-100 text-lg">Selamat datang di Panel Admin PesisirConnect. Pantau semua metrik, vendor, dan wisata dari sini.</p>
            </div>
            <a href="{{ route('home') }}" target="_blank" class="shrink-0 bg-white text-sky-600 font-semibold px-6 py-3 rounded-xl shadow-md hover:bg-sky-50 transition-all duration-200 active:scale-95">
                Lihat Landing Page
            </a>
        </div>
    </div>
</x-filament-widgets::widget>
