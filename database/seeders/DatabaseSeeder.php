<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ──────────────────────────────────────
        // 1. Admin User
        // ──────────────────────────────────────
        User::factory()->admin()->create([
            'name'  => 'Admin PesisirConnect',
            'email' => 'admin@pesisirconnect.com',
            'phone' => '081234567890',
        ]);

        // ──────────────────────────────────────
        // 2. Vendor Users
        // ──────────────────────────────────────
        $vendors = User::factory()->vendor()->count(5)->create();

        // ──────────────────────────────────────
        // 3. Customer Users
        // ──────────────────────────────────────
        User::factory()->count(10)->create();

        // ──────────────────────────────────────
        // 4. Categories
        // ──────────────────────────────────────
        $categories = collect([
            [
                'name'        => 'Sewa Perahu Wisata',
                'slug'        => 'sewa-perahu-wisata',
                'description' => 'Sewa perahu tradisional dan speedboat untuk menjelajahi pulau-pulau indah di pesisir Lampung.',
                'image'       => 'images/categories/boat.png',
                'sort_order'  => 1,
            ],
            [
                'name'        => 'Alat Snorkeling',
                'slug'        => 'alat-snorkeling',
                'description' => 'Sewa peralatan snorkeling lengkap untuk menikmati keindahan terumbu karang.',
                'image'       => 'images/categories/snorkeling.png',
                'sort_order'  => 2,
            ],
            [
                'name'        => 'Homestay',
                'slug'        => 'homestay',
                'description' => 'Penginapan lokal yang nyaman dengan pemandangan laut dan suasana pesisir autentik.',
                'image'       => 'images/categories/homestay.png',
                'sort_order'  => 3,
            ],
        ])->map(fn ($data) => Category::create($data));

        // ──────────────────────────────────────
        // 5. Products — Sewa Perahu Wisata
        // ──────────────────────────────────────
        $boatNames = [
            ['name' => 'Perahu Wisata Pahawang Express', 'location' => 'Pahawang', 'price' => 350000, 'capacity' => 10],
            ['name' => 'Speedboat Teluk Kiluan Adventure', 'location' => 'Teluk Kiluan', 'price' => 500000, 'capacity' => 8],
            ['name' => 'Perahu Nelayan Krui Sunset Tour', 'location' => 'Krui', 'price' => 250000, 'capacity' => 6],
            ['name' => 'Island Hopping Boat Pahawang', 'location' => 'Pahawang', 'price' => 750000, 'capacity' => 15],
        ];

        foreach ($boatNames as $boat) {
            Product::factory()->create([
                'user_id'           => $vendors->random()->id,
                'category_id'       => $categories[0]->id,
                'name'              => $boat['name'],
                'location'          => $boat['location'],
                'price'             => $boat['price'],
                'price_unit'        => 'trip',
                'capacity'          => $boat['capacity'],
                'facilities'        => ['Life Jacket', 'Guide', 'P3K', 'Air Mineral'],
                'is_featured'       => true,
                'thumbnail'         => 'images/categories/boat.png',
            ]);
        }

        // ──────────────────────────────────────
        // 6. Products — Alat Snorkeling
        // ──────────────────────────────────────
        $snorkelNames = [
            ['name' => 'Paket Snorkeling Basic Pahawang', 'location' => 'Pahawang', 'price' => 50000],
            ['name' => 'Full Set Snorkeling Premium', 'location' => 'Pahawang', 'price' => 100000],
            ['name' => 'Snorkeling Gear Kiluan Bay', 'location' => 'Teluk Kiluan', 'price' => 75000],
        ];

        foreach ($snorkelNames as $snorkel) {
            Product::factory()->create([
                'user_id'           => $vendors->random()->id,
                'category_id'       => $categories[1]->id,
                'name'              => $snorkel['name'],
                'location'          => $snorkel['location'],
                'price'             => $snorkel['price'],
                'price_unit'        => 'set',
                'facilities'        => ['Masker', 'Snorkel', 'Fin', 'Life Jacket'],
                'is_featured'       => true,
                'thumbnail'         => 'images/categories/snorkeling.png',
            ]);
        }

        // ──────────────────────────────────────
        // 7. Products — Homestay
        // ──────────────────────────────────────
        $homestayNames = [
            ['name' => 'Pahawang Beach Homestay', 'location' => 'Pahawang', 'price' => 350000, 'capacity' => 4],
            ['name' => 'Sunset Villa Krui', 'location' => 'Krui', 'price' => 500000, 'capacity' => 6],
            ['name' => 'Kiluan Bay Lodge', 'location' => 'Teluk Kiluan', 'price' => 400000, 'capacity' => 3],
            ['name' => 'Oceanview Cottage Pahawang', 'location' => 'Pahawang', 'price' => 750000, 'capacity' => 4],
            ['name' => 'Rumah Pantai Krui Surf House', 'location' => 'Krui', 'price' => 600000, 'capacity' => 8],
        ];

        foreach ($homestayNames as $homestay) {
            Product::factory()->create([
                'user_id'           => $vendors->random()->id,
                'category_id'       => $categories[2]->id,
                'name'              => $homestay['name'],
                'location'          => $homestay['location'],
                'price'             => $homestay['price'],
                'price_unit'        => 'malam',
                'capacity'          => $homestay['capacity'],
                'facilities'        => fake()->randomElements(
                    ['WiFi', 'AC', 'Kamar Mandi Dalam', 'Parkir', 'Sarapan', 'Dapur Bersama', 'Laundry', 'TV'],
                    fake()->numberBetween(3, 6)
                ),
                'is_featured'       => true,
                'thumbnail'         => 'images/categories/homestay.png',
            ]);
        }
    }
}
