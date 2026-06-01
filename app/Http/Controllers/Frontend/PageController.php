<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
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
     * Saat ini menggunakan data statis. Ke depan bisa diganti
     * dengan query ke tabel `destinations` di database.
     */
    public function destinasi(): View
    {
        $destinations = collect([
            [
                'name'        => 'Pulau Pahawang',
                'slug'        => 'pahawang',
                'tagline'     => 'Surga Snorkeling Lampung',
                'description' => 'Pulau Pahawang terkenal dengan terumbu karang yang masih alami dan air laut yang jernih. Destinasi sempurna untuk snorkeling, diving, dan menikmati keindahan bawah laut tropis. Hanya 1,5 jam perjalanan laut dari Dermaga Ketapang.',
                'highlights'  => ['Snorkeling & Diving', 'Terumbu Karang Alami', 'Island Hopping', 'Sunset Point'],
                'image'       => 'destinations/pahawang.png',
                'location'    => 'Pesawaran, Lampung',
                'rating'      => 4.8,
                'reviews'     => 324,
            ],
            [
                'name'        => 'Pantai Krui',
                'slug'        => 'krui',
                'tagline'     => 'Ombak Kelas Dunia',
                'description' => 'Krui adalah surga tersembunyi para peselancar dengan ombak kelas dunia yang sudah diakui internasional. Pantainya yang panjang dengan pasir putih dikelilingi tebing dan hutan tropis, menawarkan pengalaman surfing dan sunset yang tak terlupakan.',
                'highlights'  => ['World-Class Surfing', 'Pantai Pasir Putih', 'Tebing & Goa Laut', 'Kuliner Pesisir'],
                'image'       => 'destinations/krui.png',
                'location'    => 'Pesisir Barat, Lampung',
                'rating'      => 4.7,
                'reviews'     => 256,
            ],
            [
                'name'        => 'Teluk Kiluan',
                'slug'        => 'kiluan',
                'tagline'     => 'Rumah Para Lumba-Lumba',
                'description' => 'Teluk Kiluan menawarkan pengalaman unik menyaksikan lumba-lumba berenang bebas di habitat aslinya. Dikelilingi perbukitan hijau dan pantai yang tenang, tempat ini cocok untuk wisata edukasi dan ekowisata yang mendukung masyarakat lokal.',
                'highlights'  => ['Dolphin Watching', 'Ekowisata', 'Pantai Virgin', 'Camping & Trekking'],
                'image'       => 'destinations/kiluan.png',
                'location'    => 'Tanggamus, Lampung',
                'rating'      => 4.9,
                'reviews'     => 412,
            ],
        ]);

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
}
