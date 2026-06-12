<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * Membuat data awal lengkap untuk development & testing:
     * - 1 Admin
     * - 3 Vendor (approved) + 1 Vendor (pending) + profil vendor
     * - 10 Customer
     * - 6 Kategori produk wisata pesisir
     * - 12+ Produk sampel di 3 lokasi utama
     */
    public function run(): void
    {
        // ──────────────────────────────────────
        // 1. Admin User
        // ──────────────────────────────────────
        User::create([
            'name'              => 'Admin PesisirConnect',
            'email'             => 'admin@pesisirconnect.com',
            'email_verified_at' => now(),
            'password'          => Hash::make('password'),
            'role'              => 'admin',
            'phone'             => '081234567890',
            'is_active'         => true,
        ]);

        // ──────────────────────────────────────
        // 2. Vendor Users + Vendor Profiles
        // ──────────────────────────────────────
        $vendorData = [
            [
                'user' => [
                    'name'  => 'Pak Hendra',
                    'email' => 'hendra@pesisirconnect.com',
                    'phone' => '081234567891',
                ],
                'vendor' => [
                    'shop_name'     => 'Pahawang Jaya Tour',
                    'business_type' => 'kapal',
                    'phone'         => '081234567891',
                    'address'       => 'Dermaga Ketapang, Pesawaran',
                    'city'          => 'Pesawaran',
                    'zip_code'      => '35363',
                    'bank_name'     => 'BRI',
                    'account_holder' => 'Hendra Saputra',
                    'account_number' => '0012345678901',
                    'bio'           => 'Menyediakan jasa sewa perahu wisata dan paket island hopping ke Pulau Pahawang sejak 2015. Kapten berpengalaman, kapal terawat, dan keselamatan utama.',
                    'status'        => 'approved',
                    'is_approved'   => true,
                    'verified_at'   => now()->subDays(30),
                    'commission_rate' => 10,
                ],
            ],
            [
                'user' => [
                    'name'  => 'Bu Siti Rahayu',
                    'email' => 'siti@pesisirconnect.com',
                    'phone' => '081234567892',
                ],
                'vendor' => [
                    'shop_name'     => 'Kiluan Paradise Stay',
                    'business_type' => 'penginapan',
                    'phone'         => '081234567892',
                    'address'       => 'Jl. Teluk Kiluan No. 12, Tanggamus',
                    'city'          => 'Tanggamus',
                    'zip_code'      => '35384',
                    'bank_name'     => 'BCA',
                    'account_holder' => 'Siti Rahayu',
                    'account_number' => '1234567890',
                    'bio'           => 'Homestay nyaman dengan pemandangan Teluk Kiluan. Dilengkapi fasilitas lengkap dan sarapan tradisional. Cocok untuk keluarga dan pasangan.',
                    'status'        => 'approved',
                    'is_approved'   => true,
                    'verified_at'   => now()->subDays(20),
                    'commission_rate' => 10,
                ],
            ],
            [
                'user' => [
                    'name'  => 'Mas Doni Firmansyah',
                    'email' => 'doni@pesisirconnect.com',
                    'phone' => '081234567893',
                ],
                'vendor' => [
                    'shop_name'     => 'Krui Surf & Dive',
                    'business_type' => 'wisata',
                    'phone'         => '081234567893',
                    'address'       => 'Jl. Pantai Krui, Pesisir Barat',
                    'city'          => 'Pesisir Barat',
                    'zip_code'      => '35174',
                    'bank_name'     => 'Mandiri',
                    'account_holder' => 'Doni Firmansyah',
                    'account_number' => '1380012345678',
                    'bio'           => 'Paket wisata surfing, diving, dan snorkeling di pesisir Krui. Instruktur bersertifikat, peralatan premium, dan pengalaman tak terlupakan di ombak kelas dunia.',
                    'status'        => 'approved',
                    'is_approved'   => true,
                    'verified_at'   => now()->subDays(15),
                    'commission_rate' => 12,
                ],
            ],
            [
                'user' => [
                    'name'  => 'Pak Wahyu',
                    'email' => 'wahyu@pesisirconnect.com',
                    'phone' => '081234567894',
                ],
                'vendor' => [
                    'shop_name'     => 'Wahyu Bahari Transport',
                    'business_type' => 'kapal',
                    'phone'         => '081234567894',
                    'address'       => 'Pelabuhan Bakauheni, Lampung Selatan',
                    'city'          => 'Lampung Selatan',
                    'zip_code'      => '35512',
                    'bank_name'     => 'BNI',
                    'account_holder' => 'Wahyu Prasetyo',
                    'account_number' => '0987654321',
                    'bio'           => 'Vendor baru yang menyediakan transportasi laut untuk wisata di pesisir Lampung.',
                    'status'        => 'pending_approval',
                    'is_approved'   => false,
                    'verified_at'   => null,
                    'commission_rate' => 10,
                ],
            ],
        ];

        $vendors = collect();

        foreach ($vendorData as $data) {
            $user = User::create([
                'name'              => $data['user']['name'],
                'email'             => $data['user']['email'],
                'email_verified_at' => now(),
                'password'          => Hash::make('password'),
                'role'              => 'vendor',
                'phone'             => $data['user']['phone'],
                'is_active'         => true,
            ]);

            $vendor = Vendor::create(array_merge(
                $data['vendor'],
                ['user_id' => $user->id]
            ));

            $vendors->push($vendor);
        }

        // Only use approved vendors for products
        $approvedVendors = $vendors->filter(fn ($v) => $v->is_approved);

        // ──────────────────────────────────────
        // 3. Customer Users
        // ──────────────────────────────────────
        $customerNames = [
            ['name' => 'Ahmad Rizki',    'email' => 'ahmad@example.com'],
            ['name' => 'Dewi Lestari',   'email' => 'dewi@example.com'],
            ['name' => 'Budi Santoso',   'email' => 'budi@example.com'],
            ['name' => 'Rina Wulandari', 'email' => 'rina@example.com'],
            ['name' => 'Eko Prasetyo',   'email' => 'eko@example.com'],
        ];

        foreach ($customerNames as $cust) {
            User::create([
                'name'              => $cust['name'],
                'email'             => $cust['email'],
                'email_verified_at' => now(),
                'password'          => Hash::make('password'),
                'role'              => 'customer',
                'phone'             => '08' . fake()->numerify('##########'),
                'is_active'         => true,
            ]);
        }

        // ──────────────────────────────────────
        // 4. Categories
        // ──────────────────────────────────────
        $categories = collect([
            [
                'name'        => 'Sewa Perahu Wisata',
                'slug'        => 'sewa-perahu-wisata',
                'description' => 'Sewa perahu tradisional dan speedboat untuk menjelajahi pulau-pulau indah di pesisir Lampung.',
                'icon'        => '⛵',
                'sort_order'  => 1,
            ],
            [
                'name'        => 'Alat Snorkeling',
                'slug'        => 'alat-snorkeling',
                'description' => 'Sewa peralatan snorkeling lengkap untuk menikmati keindahan terumbu karang.',
                'icon'        => '🤿',
                'sort_order'  => 2,
            ],
            [
                'name'        => 'Homestay',
                'slug'        => 'homestay',
                'description' => 'Penginapan lokal yang nyaman dengan pemandangan laut dan suasana pesisir autentik.',
                'icon'        => '🏠',
                'sort_order'  => 3,
            ],
            [
                'name'        => 'Paket Wisata',
                'slug'        => 'paket-wisata',
                'description' => 'Paket wisata lengkap termasuk transportasi, akomodasi, dan aktivitas di pesisir Lampung.',
                'icon'        => '🎒',
                'sort_order'  => 4,
            ],
            [
                'name'        => 'Kuliner Pesisir',
                'slug'        => 'kuliner-pesisir',
                'description' => 'Nikmati kuliner khas pesisir Lampung — seafood segar, olahan tradisional, dan jajanan khas.',
                'icon'        => '🦐',
                'sort_order'  => 5,
            ],
            [
                'name'        => 'Guide & Pemandu',
                'slug'        => 'guide-pemandu',
                'description' => 'Jasa pemandu wisata lokal yang berpengalaman untuk menjelajahi destinasi pesisir.',
                'icon'        => '🧭',
                'sort_order'  => 6,
            ],
        ])->map(fn ($data) => Category::create($data));

        // ──────────────────────────────────────
        // 5. Products — Sewa Perahu Wisata
        // ──────────────────────────────────────
        $boatProducts = [
            [
                'name'        => 'Perahu Wisata Pahawang Express',
                'location'    => 'Pahawang',
                'price'       => 350000,
                'price_unit'  => 'trip',
                'capacity'    => 10,
                'description' => 'Perahu wisata cepat dan nyaman untuk menjelajahi Pulau Pahawang. Dilengkapi life jacket, guide berpengalaman, dan P3K. Perjalanan sekitar 1,5 jam dari Dermaga Ketapang dengan pemandangan laut yang memukau.',
                'short_description' => 'Perahu wisata ke Pahawang, kapasitas 10 orang',
                'facilities'  => ['Life Jacket', 'Guide Wisata', 'P3K', 'Air Mineral', 'Snack'],
                'whatsapp'    => '081234567891',
                'rating'      => 4.7,
                'total_reviews' => 45,
            ],
            [
                'name'        => 'Speedboat Teluk Kiluan Adventure',
                'location'    => 'Teluk Kiluan',
                'price'       => 500000,
                'price_unit'  => 'trip',
                'capacity'    => 8,
                'description' => 'Speedboat modern untuk petualangan ke Teluk Kiluan. Cocok untuk dolphin watching di pagi hari. Kapten berpengalaman dengan pengetahuan spot-spot terbaik untuk melihat lumba-lumba.',
                'short_description' => 'Speedboat dolphin watching di Teluk Kiluan',
                'facilities'  => ['Life Jacket', 'Guide', 'P3K', 'Teropong', 'Air Mineral'],
                'whatsapp'    => '081234567891',
                'rating'      => 4.9,
                'total_reviews' => 78,
            ],
            [
                'name'        => 'Perahu Nelayan Krui Sunset Tour',
                'location'    => 'Krui',
                'price'       => 250000,
                'price_unit'  => 'trip',
                'capacity'    => 6,
                'description' => 'Nikmati sunset dari perahu nelayan tradisional di pesisir Krui. Pengalaman autentik bersama nelayan lokal sambil menikmati keindahan pantai Krui dari laut.',
                'short_description' => 'Sunset tour dengan perahu nelayan tradisional',
                'facilities'  => ['Life Jacket', 'Guide Lokal', 'Teh Hangat'],
                'whatsapp'    => '081234567893',
                'rating'      => 4.5,
                'total_reviews' => 23,
            ],
            [
                'name'        => 'Island Hopping Boat Pahawang',
                'location'    => 'Pahawang',
                'price'       => 750000,
                'price_unit'  => 'trip',
                'capacity'    => 15,
                'description' => 'Paket island hopping premium ke Pahawang Besar dan Pahawang Kecil. Termasuk makan siang seafood di pulau, snorkeling gear, dan guide berpengalaman. Full day trip dari jam 7 pagi hingga 5 sore.',
                'short_description' => 'Full day island hopping ke Pahawang Besar & Kecil',
                'facilities'  => ['Life Jacket', 'Guide', 'P3K', 'Makan Siang', 'Snorkeling Gear', 'Dokumentasi'],
                'whatsapp'    => '081234567891',
                'rating'      => 4.8,
                'total_reviews' => 112,
            ],
        ];

        foreach ($boatProducts as $boat) {
            $vendor = $approvedVendors->random();
            Product::create(array_merge($boat, [
                'user_id'     => $vendor->user_id,
                'vendor_id'   => $vendor->id,
                'category_id' => $categories[0]->id,
                'thumbnail'   => 'https://placehold.co/800x600/0284c7/ffffff?text=' . urlencode($boat['name']),
                'is_featured' => true,
                'is_active'   => true,
                'status'      => 'active',
                'stock'       => fake()->numberBetween(5, 30),
            ]));
        }

        // ──────────────────────────────────────
        // 6. Products — Alat Snorkeling
        // ──────────────────────────────────────
        $snorkelProducts = [
            [
                'name'        => 'Paket Snorkeling Basic Pahawang',
                'location'    => 'Pahawang',
                'price'       => 50000,
                'price_unit'  => 'set',
                'description' => 'Paket dasar peralatan snorkeling untuk menikmati keindahan terumbu karang Pahawang. Termasuk masker, snorkel, dan life jacket.',
                'short_description' => 'Peralatan snorkeling dasar di Pahawang',
                'facilities'  => ['Masker', 'Snorkel', 'Life Jacket'],
                'whatsapp'    => '081234567893',
                'rating'      => 4.3,
                'total_reviews' => 67,
            ],
            [
                'name'        => 'Full Set Snorkeling Premium',
                'location'    => 'Pahawang',
                'price'       => 100000,
                'price_unit'  => 'set',
                'description' => 'Set lengkap peralatan snorkeling premium kualitas terbaik. Termasuk masker anti-fog, dry snorkel, fin, wetsuit, dan underwater camera rental.',
                'short_description' => 'Set lengkap snorkeling premium dengan kamera bawah air',
                'facilities'  => ['Masker Anti-Fog', 'Dry Snorkel', 'Fin', 'Wetsuit', 'Life Jacket', 'Kamera Underwater'],
                'whatsapp'    => '081234567893',
                'rating'      => 4.6,
                'total_reviews' => 34,
            ],
            [
                'name'        => 'Snorkeling Gear Kiluan Bay',
                'location'    => 'Teluk Kiluan',
                'price'       => 75000,
                'price_unit'  => 'set',
                'description' => 'Peralatan snorkeling untuk menjelajahi terumbu karang di perairan Teluk Kiluan. Kualitas terjaga dan rutin dibersihkan.',
                'short_description' => 'Peralatan snorkeling di Teluk Kiluan',
                'facilities'  => ['Masker', 'Snorkel', 'Fin', 'Life Jacket'],
                'whatsapp'    => '081234567892',
                'rating'      => 4.4,
                'total_reviews' => 19,
            ],
        ];

        foreach ($snorkelProducts as $snorkel) {
            $vendor = $approvedVendors->random();
            Product::create(array_merge($snorkel, [
                'user_id'     => $vendor->user_id,
                'vendor_id'   => $vendor->id,
                'category_id' => $categories[1]->id,
                'thumbnail'   => 'https://placehold.co/800x600/0891b2/ffffff?text=' . urlencode($snorkel['name']),
                'is_featured' => true,
                'is_active'   => true,
                'status'      => 'active',
                'stock'       => fake()->numberBetween(10, 50),
            ]));
        }

        // ──────────────────────────────────────
        // 7. Products — Homestay
        // ──────────────────────────────────────
        $homestayProducts = [
            [
                'name'        => 'Pahawang Beach Homestay',
                'location'    => 'Pahawang',
                'price'       => 350000,
                'price_unit'  => 'malam',
                'capacity'    => 4,
                'description' => 'Homestay tepi pantai di Pulau Pahawang dengan pemandangan laut langsung dari teras. Kamar bersih, kamar mandi dalam, dan sarapan tradisional sudah termasuk.',
                'short_description' => 'Homestay tepi pantai dengan sarapan di Pahawang',
                'facilities'  => ['WiFi', 'Kamar Mandi Dalam', 'Sarapan', 'Teras Laut', 'Parkir'],
                'whatsapp'    => '081234567892',
                'rating'      => 4.6,
                'total_reviews' => 89,
            ],
            [
                'name'        => 'Sunset Villa Krui',
                'location'    => 'Krui',
                'price'       => 500000,
                'price_unit'  => 'malam',
                'capacity'    => 6,
                'description' => 'Villa modern dengan sentuhan lokal, menghadap pantai Krui. Dilengkapi AC, dapur mini, dan area bersantai outdoor. Lokasi strategis dekat spot surfing.',
                'short_description' => 'Villa modern menghadap pantai surfing Krui',
                'facilities'  => ['AC', 'WiFi', 'Dapur Mini', 'Kamar Mandi Dalam', 'Parkir', 'TV'],
                'whatsapp'    => '081234567892',
                'rating'      => 4.8,
                'total_reviews' => 56,
            ],
            [
                'name'        => 'Kiluan Bay Lodge',
                'location'    => 'Teluk Kiluan',
                'price'       => 400000,
                'price_unit'  => 'malam',
                'capacity'    => 3,
                'description' => 'Lodge minimalis di tepi Teluk Kiluan. Cocok untuk wisatawan yang ingin menikmati ketenangan dan keindahan teluk. Sarapan dan akses pantai pribadi termasuk.',
                'short_description' => 'Lodge minimalis tepi Teluk Kiluan',
                'facilities'  => ['Sarapan', 'Kamar Mandi Dalam', 'Pantai Pribadi', 'Hammock'],
                'whatsapp'    => '081234567892',
                'rating'      => 4.7,
                'total_reviews' => 41,
            ],
            [
                'name'        => 'Oceanview Cottage Pahawang',
                'location'    => 'Pahawang',
                'price'       => 750000,
                'price_unit'  => 'malam',
                'capacity'    => 4,
                'description' => 'Cottage premium di ketinggian dengan pemandangan 180° lautan Pahawang. Full furnish, AC, hot shower, dan layanan antar-jemput dari dermaga.',
                'short_description' => 'Cottage premium pemandangan 180° laut Pahawang',
                'facilities'  => ['AC', 'Hot Shower', 'WiFi', 'Antar Jemput', 'Sarapan', 'Laundry'],
                'whatsapp'    => '081234567892',
                'rating'      => 4.9,
                'total_reviews' => 67,
            ],
            [
                'name'        => 'Rumah Pantai Krui Surf House',
                'location'    => 'Krui',
                'price'       => 600000,
                'price_unit'  => 'malam',
                'capacity'    => 8,
                'description' => 'Surf house lengkap untuk komunitas surfer. Ada surf rack, outdoor shower, dan akses langsung ke spot surfing terbaik di Krui. Atmosfer backpacker friendly.',
                'short_description' => 'Surf house dengan akses langsung ke ombak Krui',
                'facilities'  => ['Surf Rack', 'WiFi', 'Dapur Bersama', 'Outdoor Shower', 'Lounge Area', 'Board Rental'],
                'whatsapp'    => '081234567893',
                'rating'      => 4.5,
                'total_reviews' => 38,
            ],
        ];

        foreach ($homestayProducts as $homestay) {
            $vendor = $approvedVendors->random();
            Product::create(array_merge($homestay, [
                'user_id'     => $vendor->user_id,
                'vendor_id'   => $vendor->id,
                'category_id' => $categories[2]->id,
                'thumbnail'   => 'https://placehold.co/800x600/059669/ffffff?text=' . urlencode($homestay['name']),
                'is_featured' => true,
                'is_active'   => true,
                'status'      => 'active',
                'stock'       => fake()->numberBetween(1, 10),
            ]));
        }

        // ──────────────────────────────────────
        // 8. Products — Paket Wisata
        // ──────────────────────────────────────
        $paketWisata = [
            [
                'name'        => 'Paket Pahawang 2H1M All-In',
                'location'    => 'Pahawang',
                'price'       => 899000,
                'price_unit'  => 'orang',
                'capacity'    => 20,
                'description' => 'Paket wisata lengkap 2 hari 1 malam ke Pahawang. Termasuk transportasi boat PP, homestay, makan 3x, snorkeling gear, guide, dan dokumentasi foto underwater.',
                'short_description' => 'Paket komplit 2H1M Pahawang termasuk semua fasilitas',
                'facilities'  => ['Transportasi PP', 'Homestay', 'Makan 3x', 'Snorkeling Gear', 'Guide', 'Dokumentasi'],
                'whatsapp'    => '081234567891',
                'rating'      => 4.8,
                'total_reviews' => 156,
            ],
            [
                'name'        => 'Dolphin Watching Tour Kiluan',
                'location'    => 'Teluk Kiluan',
                'price'       => 450000,
                'price_unit'  => 'orang',
                'capacity'    => 12,
                'description' => 'Paket dolphin watching eksklusif di Teluk Kiluan. Berangkat pagi hari untuk menyaksikan lumba-lumba liar di habitat aslinya. Termasuk sarapan dan makan siang seafood.',
                'short_description' => 'Dolphin watching eksklusif di Teluk Kiluan',
                'facilities'  => ['Transportasi Laut', 'Sarapan', 'Makan Siang', 'Guide', 'Teropong', 'P3K'],
                'whatsapp'    => '081234567892',
                'rating'      => 4.9,
                'total_reviews' => 203,
            ],
        ];

        foreach ($paketWisata as $paket) {
            $vendor = $approvedVendors->random();
            Product::create(array_merge($paket, [
                'user_id'     => $vendor->user_id,
                'vendor_id'   => $vendor->id,
                'category_id' => $categories[3]->id,
                'thumbnail'   => 'https://placehold.co/800x600/7c3aed/ffffff?text=' . urlencode($paket['name']),
                'is_featured' => true,
                'is_active'   => true,
                'status'      => 'active',
                'stock'       => fake()->numberBetween(5, 20),
            ]));
        }
    }
}
