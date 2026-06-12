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
        // 1. Admin User
        User::create([
            'name'      => 'Admin User',
            'email'     => 'admin@pesisirconnect.com',
            'password'  => bcrypt('password'), // default password
            'role'      => 'admin',
            'is_active' => true,
        ]);

        // 2. Vendor User
        User::create([
            'name'      => 'Vendor User',
            'email'     => 'vendor@pesisirconnect.com',
            'password'  => bcrypt('password'),
            'role'      => 'vendor',
            'is_active' => true,
        ]);

        // 3. Customer User
        User::create([
            'name'      => 'Customer User',
            'email'     => 'customer@pesisirconnect.com',
            'password'  => bcrypt('password'),
            'role'      => 'customer',
            'is_active' => true, // Customers generally active
        ]);
    }
}
