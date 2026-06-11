<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::firstOrCreate([
            'email' => 'superadmin@pesisirconnect.com'
        ], [
            'name' => 'Super Admin',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);
    }
}
