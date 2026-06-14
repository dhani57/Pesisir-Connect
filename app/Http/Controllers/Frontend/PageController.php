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
        $destinations = \App\Models\Destination::all();

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
