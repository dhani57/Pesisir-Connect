# PRODUCT REQUIREMENT DOCUMENT (PRD) - FOCUS: SUPER ADMIN

## 1. Sistem & Konteks Bisnis
PesisirConnect adalah marketplace pariwisata C2C/B2C di pesisir Lampung (Pahawang, Krui, Teluk Kiluan). Sistem ini bertindak sebagai intermediari bisnis. Sistem HANYA memiliki 3 role mutlak pada tabel `users`: 'admin', 'vendor', dan 'customer'.

## 2. Batasan Scope Kerja (PENTING)
- Proyek ini dikerjakan secara TIM. Ruang lingkup kerja SAYA adalah memegang kendali penuh atas "Pusat Kontrol Global" yaitu panel Super Admin dan Alur Autentikasi Utama.
- Ruang lingkup "Vendor Dashboard/Dashboard Pengelola Tempat" dikerjakan oleh PARTNER saya di file terpisah. 
- JANGAN menuliskan atau mengubah logika internal khusus operasional vendor kecuali jika berkaitan langsung dengan tabel relasi global atau persetujuan admin.

## 3. Standar Arsitektur & Aturan Kode (Clean Code)
- **Framework:** Laravel 13, Tailwind CSS, Alpine.js (TALL Stack Lightweight variant).
- **Custom UI (No Filament Layout):** Kita TIDAK menggunakan layout/panel standar bawaan Filament karena dinilai terlalu kaku. Dashboard Admin wajib dibangun secara MANDIRI menggunakan Custom Laravel Blade Components (`<x-admin-layout>`) dan Tailwind CSS agar desainnya 100% konsisten dengan halaman pengguna.
- **Strict Typing:** Setiap Controller, Middleware, dan Service wajib menggunakan strict type hinting dan return types yang jelas.
- **Database Optimization:** Mencegah N+1 query menggunakan eager loading (`with()`) pada setiap pemanggilan data relasi tabel transaksi.

## 4. Standar Desain (Ocean Blue Enterprise & Mobile-First)
- **Tema Warna:** Admin Dashboard menggunakan visual premium skala enterprise. Sidebar vertikal menggunakan warna Deep Ocean Blue (`bg-slate-900` atau `bg-sky-950`). Komponen kartu dan konten menggunakan latar putih bersih dengan drop shadow lembut di atas background utama Off-White (`bg-slate-50`).
- **Aksen CTA:** Tombol konfirmasi penting atau warning menggunakan warna Coral Sunset (`bg-rose-500`).
- **Mobile-First Responsive:** Di layar smartphone, sidebar wajib otomatis bersembunyi (collapsible/off-canvas menu) menggunakan toggle state dari Alpine.js, dan layout grid statistik otomatis bertumpuk menjadi 1 kolom vertikal.

## 5. Hak Akses & Fungsionalitas Utama Admin
Admin memiliki hak kontrol tertinggi (God Mode) terhadap platform dengan 5 modul utama:
1. **Dasbor Metrik Global:** Menampilkan agregasi data real-time: Total Pendapatan Platform (akumulasi Midtrans sukses), Total Vendor Aktif, dan Total Transaksi Sukses.
2. **Sistem Verifikasi Vendor (User Management):** Menampilkan tabel pengguna. Admin berhak mengubah status `is_active` (boolean) akun ber-role 'vendor' dari false (Pending) menjadi true (Approved) agar mereka bisa mulai berjualan di sistem.
3. **Manajemen Kategori Wisata:** CRUD data master kategori (Sewa Perahu, Homestay, Alat Snorkeling) yang akan digunakan di halaman katalog.
4. **Manajemen Konten Destinasi:** Mengelola artikel promosi statis daerah pesisir Lampung untuk menarik wisatawan (Nama tempat, foto cover, lokasi, deskripsi).
5. **Audit Finansial Global:** Memantau laporan arus kas masuk dari seluruh transaksi produk milik semua vendor tanpa terkecuali, lengkap dengan status dari Midtrans (Pending/Success/Failed).
