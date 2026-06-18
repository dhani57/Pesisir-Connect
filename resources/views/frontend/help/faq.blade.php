<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>FAQ — PesisirConnect</title>
    <meta name="description" content="Pertanyaan yang sering diajukan mengenai PesisirConnect.">

    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect width='100' height='100' rx='20' fill='%230ea5e9'/><text x='50' y='75' font-size='70' font-family='sans-serif' font-weight='bold' fill='white' text-anchor='middle'>PC</text></svg>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">

    <style>[x-cloak] { display: none !important; }</style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50">

    <x-navbar />

    <section class="relative pt-24 pb-16 bg-gradient-to-br from-ocean-900 to-ocean-950 overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
        <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center pt-8">
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white mb-4">Pertanyaan yang Sering Diajukan <span class="text-ocean-400">(FAQ)</span></h1>
            <p class="text-ocean-100 text-lg max-w-2xl mx-auto">Temukan jawaban atas berbagai pertanyaan seputar layanan PesisirConnect.</p>
        </div>
    </section>

    <section class="py-16 md:py-24">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            @foreach($faqs as $category => $questions)
                <div class="mb-12">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <x-heroicon-o-information-circle class="w-6 h-6 text-ocean-600" />
                        {{ $category }}
                    </h2>
                    
                    <div class="space-y-4" x-data="{ activeAccordion: null }">
                        @foreach($questions as $index => $faq)
                            <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden transition-all duration-200" :class="activeAccordion === {{ $loop->parent->index . $index }} ? 'ring-2 ring-ocean-500 border-ocean-500' : ''">
                                <button @click="activeAccordion === {{ $loop->parent->index . $index }} ? activeAccordion = null : activeAccordion = {{ $loop->parent->index . $index }}" class="w-full flex items-center justify-between p-5 text-left focus:outline-none">
                                    <span class="font-semibold text-gray-900" :class="activeAccordion === {{ $loop->parent->index . $index }} ? 'text-ocean-700' : ''">{{ $faq['q'] }}</span>
                                    <svg class="w-5 h-5 text-gray-400 transform transition-transform duration-200" :class="activeAccordion === {{ $loop->parent->index . $index }} ? 'rotate-180 text-ocean-600' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                </button>
                                <div x-show="activeAccordion === {{ $loop->parent->index . $index }}" x-collapse x-cloak>
                                    <div class="p-5 pt-0 text-gray-600 leading-relaxed border-t border-gray-100 mt-1">
                                        {{ $faq['a'] }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <div class="mt-12 p-8 bg-ocean-50 rounded-2xl border border-ocean-100 text-center">
                <h3 class="text-lg font-bold text-gray-900 mb-2">Masih Memiliki Pertanyaan?</h3>
                <p class="text-gray-600 mb-6 text-sm">Jika Anda tidak menemukan jawaban yang Anda cari, jangan ragu untuk menghubungi tim dukungan kami.</p>
                @php
                    $waNumber = preg_replace('/[^0-9]/', '', setting('support_whatsapp', '081234567890'));
                    if (str_starts_with($waNumber, '0')) {
                        $waNumber = '62' . substr($waNumber, 1);
                    }
                @endphp
                <a href="https://wa.me/{{ $waNumber }}" target="_blank" class="inline-flex items-center gap-2 px-6 py-2.5 bg-white text-ocean-600 border border-ocean-200 font-semibold rounded-lg hover:bg-ocean-50 transition-colors shadow-sm">
                    <x-heroicon-o-chat-bubble-left-ellipsis class="w-5 h-5" />
                    Hubungi Dukungan
                </a>
            </div>
        </div>
    </section>

    <x-footer />
</body>
</html>
