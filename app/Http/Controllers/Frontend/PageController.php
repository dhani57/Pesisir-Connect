<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * PageController
 *
 * Mengatur halaman-halaman frontend statis dan semi-statis
 * seperti Destinasi, Tentang, dll.
 */
class PageController extends Controller
{
    /**
     * Halaman Destinasi — menampilkan daftar destinasi utama pesisir Lampung.
     *
     * Mengambil data dari tabel `destinations` di database.
     */
    public function destinasi(): View
    {
        $destinations = \App\Models\Destination::all();
        $destinations = Destination::active()->ordered()->get();

        return view('frontend.destinasi', compact('destinations'));
    }

    /**
     * Halaman Tentang — menjelaskan misi dan visi PesisirConnect.
     */
    public function tentang(): View
    {
        $stats = [
            ['value' => '50+',  'label' => 'Layanan Wisata',       'icon' => 'compass'],
            ['value' => '3',    'label' => 'Destinasi Pesisir',    'icon' => 'map-pin'],
            ['value' => '500+', 'label' => 'Wisatawan Terlayani',  'icon' => 'users'],
            ['value' => '30+',  'label' => 'Mitra Nelayan Lokal',  'icon' => 'handshake'],
        ];

        $team = [
            ['name' => 'Tim Pengembang',  'role' => 'Teknologi & Platform',   'icon' => 'code'],
            ['name' => 'Tim Komunitas',   'role' => 'Pemberdayaan Masyarakat','icon' => 'heart'],
            ['name' => 'Tim Pariwisata',  'role' => 'Kurasi Destinasi',       'icon' => 'globe'],
        ];

        return view('frontend.tentang', compact('stats', 'team'));
    }

    /**
     * Halaman Cara Memesan
     */
    public function caraMemesan(): View
    {
        return view('frontend.help.cara-memesan');
    }

    /**
     * Halaman FAQ
     */
    public function faq(): View
    {
        $faqs = [
            'Pemesanan' => [
                [
                    'q' => 'Bagaimana cara melakukan pemesanan (booking)?',
                    'a' => 'Pilih layanan yang Anda inginkan melalui menu Katalog atau Destinasi, tentukan tanggal serta jumlah tamu, lalu klik "Pesan Sekarang". Setelah itu, ikuti petunjuk pembayaran yang tampil di layar.'
                ],
                [
                    'q' => 'Apakah saya bisa mengubah jadwal booking?',
                    'a' => 'Ya, perubahan jadwal dapat dilakukan dengan menghubungi vendor langsung melalui fitur Pesan/Chat maksimal 2 hari sebelum tanggal kedatangan, tergantung pada kebijakan masing-masing vendor.'
                ]
            ],
            'Pembayaran' => [
                [
                    'q' => 'Metode pembayaran apa saja yang tersedia?',
                    'a' => 'Kami mendukung berbagai metode pembayaran, mulai dari Virtual Account (BCA, Mandiri, BNI, BRI), Kartu Kredit, hingga e-Wallet (GoPay, OVO, ShopeePay) yang diproses aman melalui Midtrans.'
                ],
                [
                    'q' => 'Apakah pembayaran saya aman?',
                    'a' => 'Sangat aman. Seluruh transaksi diproses oleh penyedia layanan pembayaran resmi yang terlisensi (Midtrans), dan kami tidak menyimpan data sensitif seperti nomor kartu kredit Anda.'
                ]
            ],
            'Kebijakan Pembatalan' => [
                [
                    'q' => 'Bagaimana jika saya ingin membatalkan pesanan?',
                    'a' => 'Pesanan yang berstatus "Menunggu Pembayaran" dapat dibatalkan langsung melalui Dashboard Anda. Namun, pesanan yang sudah dibayar perlu mendapatkan persetujuan refund dari Vendor.'
                ]
            ]
        ];

        return view('frontend.help.faq', compact('faqs'));
    }

    /**
     * Halaman Kebijakan Privasi
     */
    public function kebijakanPrivasi(): View
    {
        return view('frontend.help.kebijakan-privasi');
    }
}
