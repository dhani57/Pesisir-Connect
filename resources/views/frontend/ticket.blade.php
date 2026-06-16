<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-Ticket: {{ $transaction->invoice_number }}</title>
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🎟️</text></svg>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300..800&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .mono { font-family: 'Space Mono', monospace; }
        @media print {
            body { background: white !important; }
            .no-print { display: none !important; }
            .print-border { border: 2px solid #000 !important; }
            .ticket-shadow { box-shadow: none !important; }
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col items-center py-10 px-4">
    
    {{-- Print Controls --}}
    <div class="no-print w-full max-w-4xl flex justify-between items-center mb-8">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2 text-gray-600 hover:text-ocean-600 font-semibold transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Dashboard
        </a>
        <button onclick="window.print()" class="px-6 py-2.5 bg-ocean-600 text-white font-bold rounded-xl shadow-lg shadow-ocean-600/30 hover:bg-ocean-700 transition-all flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            Cetak Tiket / PDF
        </button>
    </div>

    {{-- The Ticket Component --}}
    <div class="w-full max-w-4xl bg-white rounded-3xl ticket-shadow shadow-2xl flex flex-col md:flex-row overflow-hidden relative print-border">
        
        {{-- Decorative Cutouts --}}
        <div class="hidden md:block absolute top-0 bottom-0 left-[68%] w-8 -ml-4 flex flex-col justify-between py-[-1rem]">
            <div class="w-8 h-8 rounded-full bg-gray-100 -mt-4 shadow-inner"></div>
            <div class="w-8 h-8 rounded-full bg-gray-100 -mb-4 shadow-inner"></div>
        </div>
        <div class="hidden md:block absolute top-0 bottom-0 left-[68%] border-l-2 border-dashed border-gray-200"></div>

        {{-- Left Part: Main Info --}}
        <div class="flex-1 p-8 md:p-12 relative">
            <div class="flex justify-between items-start mb-8">
                <div>
                    <h1 class="text-3xl font-extrabold text-ocean-700 tracking-tight mb-1">E-TICKET</h1>
                    <p class="text-sm text-gray-500 font-semibold tracking-wider uppercase">PesisirConnect Verified</p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-gray-500 uppercase tracking-widest mb-1">Invoice Number</p>
                    <p class="mono text-lg font-bold text-gray-900">{{ $transaction->invoice_number }}</p>
                </div>
            </div>

            <div class="bg-gray-50 rounded-2xl p-6 mb-8 border border-gray-100">
                <div class="grid grid-cols-2 gap-y-6 gap-x-4">
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold mb-1">Nama Pemesan</p>
                        <p class="font-bold text-gray-900">{{ $transaction->customer->name }}</p>
                        <p class="text-sm text-gray-600">{{ $transaction->customer->email }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold mb-1">Tanggal Pesanan</p>
                        <p class="font-bold text-gray-900">{{ $transaction->created_at->translatedFormat('d F Y, H:i') }}</p>
                    </div>
                </div>
            </div>

            <div>
                <p class="text-xs text-ocean-600 uppercase tracking-wider font-bold mb-2">Detail Layanan</p>
                <h2 class="text-2xl font-bold text-gray-900 mb-1">{{ $transaction->product->name }}</h2>
                <p class="text-gray-500 font-medium mb-6 flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                    {{ $transaction->product->location }}
                </p>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 py-6 border-t border-b border-gray-100">
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold mb-1">Berlaku / Check-in</p>
                        <p class="font-bold text-gray-900">{{ \Carbon\Carbon::parse($transaction->check_in)->translatedFormat('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold mb-1">Check-out</p>
                        <p class="font-bold text-gray-900">{{ $transaction->check_out ? \Carbon\Carbon::parse($transaction->check_out)->translatedFormat('d M Y') : '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold mb-1">Kuantitas</p>
                        <p class="font-bold text-gray-900">{{ $transaction->quantity }} {{ ucfirst($transaction->product->price_unit) }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold mb-1">Tamu</p>
                        <p class="font-bold text-gray-900">{{ $transaction->guests }} Orang</p>
                    </div>
                </div>
            </div>
            
            <div class="mt-6 flex items-center gap-3">
                <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-xs font-bold rounded-full uppercase tracking-wider">Telah Dibayar (PAID)</span>
                <span class="text-sm text-gray-500 font-medium">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
            </div>
        </div>

        {{-- Right Part: QR Code & Vendor --}}
        <div class="md:w-[32%] bg-ocean-600 text-white p-8 md:p-12 flex flex-col items-center justify-center relative">
            <h3 class="text-sm font-bold uppercase tracking-widest text-ocean-200 mb-6 text-center">Scan Verifikasi</h3>
            
            <div class="bg-white p-3 rounded-2xl shadow-xl mb-6">
                {{-- Generate QR Code --}}
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode(route('customer.ticket', $transaction->invoice_number)) }}&margin=0" alt="QR Code" class="w-32 h-32 md:w-40 md:h-40 object-contain">
            </div>

            <div class="text-center w-full">
                <p class="text-xs text-ocean-200 uppercase tracking-wider font-semibold mb-1">Vendor / Pengelola</p>
                <p class="font-bold text-lg mb-1 truncate" title="{{ $transaction->product->vendor->user->name }}">{{ $transaction->product->vendor->user->name }}</p>
                <p class="text-sm text-ocean-200">{{ $transaction->product->vendor->user->phone ?? 'Tidak ada kontak' }}</p>
            </div>
            
            <div class="mt-auto pt-8">
                <x-application-logo class="w-auto h-8 text-white opacity-80" />
            </div>
        </div>
    </div>

    {{-- Rules / Terms --}}
    <div class="w-full max-w-4xl mt-6 text-sm text-gray-500 bg-white p-6 rounded-2xl shadow-sm border border-gray-100 no-print">
        <h4 class="font-bold text-gray-900 mb-2">Syarat & Ketentuan Penggunaan Tiket</h4>
        <ul class="list-disc pl-5 space-y-1">
            <li>Tiket ini adalah bukti reservasi dan pembayaran yang sah.</li>
            <li>Harap tunjukkan halaman ini atau cetakan tiket kepada petugas / vendor di lokasi wisata.</li>
            <li>Vendor berhak memindai (scan) QR Code untuk memastikan keaslian tiket.</li>
            <li>Tiket tidak dapat diuangkan kembali (non-refundable) kecuali sesuai dengan kebijakan vendor terkait.</li>
        </ul>
    </div>
</body>
</html>
