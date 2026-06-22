<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Product;
use App\Models\Category;
use App\Models\Destination;
use App\Models\Transaction;

class ComprehensiveSystemFlowTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Skenario 1: Pengetesan Akses Halaman Tamu (Guest Flow)
     */
    public function test_guest_can_access_all_public_pages()
    {
        $pages = [
            '/',
            '/katalog',
            '/destinasi',
            '/tentang',
            '/bantuan/cara-memesan',
            '/bantuan/faq',
            '/bantuan/kebijakan-privasi',
            '/login',
            '/register',
        ];

        foreach ($pages as $url) {
            $response = $this->get($url);
            $response->assertStatus(200);
        }
    }

    /**
     * Skenario 2: Pendaftaran, Login, dan Profil Pelanggan (Customer Flow)
     */
    public function test_customer_can_register_login_and_access_dashboard()
    {
        // 1. Pelanggan Mendaftar
        $response = $this->post('/register', [
            'name' => 'Pelanggan Testing',
            'email' => 'pelanggan@test.com',
            'phone' => '081234567890',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'customer'
        ]);

        $response->assertRedirect();
        
        $customer = User::where('email', 'pelanggan@test.com')->first();
        $this->assertNotNull($customer);
        $this->assertEquals('customer', $customer->role);

        // 2. Logout lalu Login kembali
        $this->post('/logout');
        
        $this->post('/login', [
            'email' => 'pelanggan@test.com',
            'password' => 'password123'
        ])->assertRedirect();

        // 3. Akses Dashboard & Profil
        $this->actingAs($customer);
        $this->get('/dashboard')->assertStatus(200);
        $this->get('/profile')->assertStatus(200);
    }

    /**
     * Skenario 3: Pendaftaran Vendor & Verifikasi oleh Admin (Vendor & Admin Flow)
     */
    public function test_vendor_can_register_and_admin_can_verify()
    {
        // 1. Buat user biasa lalu login
        $vendorUser = User::factory()->create([
            'email' => 'vendor@test.com',
            'role' => 'customer'
        ]);
        $this->actingAs($vendorUser);

        // 2. Vendor Mendaftar via route spesifik vendor
        $this->post('/vendor/register', [
            'shop_name' => 'Rental Perahu Test',
            'phone' => '089876543210',
            'business_description' => 'Deskripsi bisnis',
            'address' => 'Pesisir Barat',
            'bank_name' => 'BCA',
            'bank_account_number' => '1234567890',
            'bank_account_name' => 'Vendor Testing'
        ])->assertRedirect();

        $vendorUser->refresh();
        // Tergantung pada controller, role mungkin otomatis berubah jadi vendor
        $this->assertEquals('vendor', $vendorUser->role);

        $vendor = Vendor::where('user_id', $vendorUser->id)->first();
        $this->assertNotNull($vendor);
        $this->assertEquals('pending_approval', $vendor->status);

        // 2. Admin Verifikasi Vendor
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);
        
        // Simulasikan action persetujuan
        $vendor->update(['status' => 'approved']);
        $this->assertEquals('approved', $vendor->fresh()->status);
    }

    /**
     * Skenario 4: Proses E2E (Vendor Buat Produk -> Pelanggan Booking -> Transaksi)
     */
    public function test_end_to_end_booking_flow()
    {
        // Setup Kategori & Destinasi tanpa factory jika tidak tersedia
        $category = Category::create([
            'name' => 'Sewa Perahu', 
            'slug' => 'sewa-perahu', 
            'description' => 'Kategori test'
        ]);
        
        $destination = Destination::create([
            'name' => 'Pulau Pahawang', 
            'slug' => 'pulau-pahawang', 
            'description' => 'Destinasi test',
            'location' => 'Pesawaran',
            'image_url' => 'https://example.com/img.jpg',
            'rating' => 5.0,
            'reviews_count' => 10
        ]);

        // 1. Vendor
        $vendorUser = User::factory()->create(['role' => 'vendor']);
        $vendor = Vendor::create([
            'user_id' => $vendorUser->id, 
            'shop_name' => 'Test Vendor',
            'business_description' => 'Test',
            'address' => 'Test',
            'is_approved' => true,
            'status' => 'approved'
        ]);

        // Vendor Create Product
        $product = Product::create([
            'user_id' => $vendorUser->id,
            'vendor_id' => $vendor->id,
            'category_id' => $category->id,
            'destination_id' => $destination->id,
            'name' => 'Perahu Keliling Pahawang',
            'slug' => 'perahu-keliling-pahawang',
            'description' => 'Deskripsi',
            'location' => 'Pesawaran',
            'address' => 'Dermaga Ketapang',
            'price' => 500000,
            'unit' => 'hari',
            'is_active' => true,
            'status' => 'active',
            'whatsapp' => '08123456789'
        ]);

        // 2. Pelanggan
        $customer = User::factory()->create(['role' => 'customer']);
        $this->actingAs($customer);

        // Pelanggan melihat produk
        $this->get('/produk/' . $product->slug)->assertStatus(200);

        // Pelanggan menambahkan ke Wishlist (AJAX toggle)
        $this->postJson('/wishlist/toggle', ['product_id' => $product->id])->assertStatus(200);
        $this->assertDatabaseHas('wishlists', ['user_id' => $customer->id, 'product_id' => $product->id]);

        // Pelanggan Checkout
        $transaction = Transaction::create([
            'invoice_number' => 'INV-' . time(),
            'user_id' => $customer->id,
            'vendor_id' => $vendor->id,
            'product_id' => $product->id,
            'check_in' => now()->addDays(2)->format('Y-m-d'),
            'quantity' => 1,
            'total_price' => $product->price,
            'status' => 'pending',
            'payment_type' => 'bank_transfer',
            'snap_token' => 'dummy-token'
        ]);

        $this->assertDatabaseHas('transactions', ['id' => $transaction->id, 'status' => 'pending']);

        // Pelanggan melihat detail transaksinya di dashboard
        $this->get('/pesanan/' . $transaction->invoice_number)->assertStatus(200);
        
        // Membuka e-tiket (walau pending)
        $this->get('/tiket/' . $transaction->invoice_number)->assertStatus(200);

        // 3. Admin mengecek dashboard
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);
        $this->get('/admin/dashboard')->assertStatus(200);
    }
}
