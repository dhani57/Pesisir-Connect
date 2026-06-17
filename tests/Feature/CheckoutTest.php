<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Vendor;
use App\Services\MidtransService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_checkout_process_creates_transaction_and_sends_email()
    {
        Mail::fake();

        // 1. Create a customer
        $customer = User::factory()->create([
            'role' => 'customer',
        ]);

        // 2. Create a vendor user and profile
        $vendorUser = User::factory()->create([
            'role' => 'vendor',
        ]);
        $vendor = Vendor::create([
            'user_id' => $vendorUser->id,
            'shop_name' => 'Test Vendor Shop',
            'status' => 'approved',
            'is_approved' => true,
        ]);

        // 3. Create a category
        $category = Category::create([
            'name' => 'Sewa Perahu',
            'slug' => 'sewa-perahu',
            'description' => 'Test Description',
        ]);

        // 4. Create a product
        $product = Product::create([
            'user_id' => $vendorUser->id,
            'vendor_id' => $vendor->id,
            'category_id' => $category->id,
            'name' => 'Sewa Kapal Wisata Test',
            'slug' => 'sewa-kapal-wisata-test',
            'price' => 250000,
            'price_unit' => 'trip',
            'stock' => 10,
            'description' => 'Product test description',
            'location' => 'Pahawang',
        ]);

        // 5. Mock the MidtransService to return a dummy token
        $this->mock(MidtransService::class, function ($mock) {
            $mock->shouldReceive('createSnapToken')
                 ->once()
                 ->andReturn([
                     'token' => 'mocked-snap-token-12345',
                     'redirect_url' => 'https://app.sandbox.midtrans.com/snap/v2/vtweb/mocked-snap-token-12345'
                 ]);
            $mock->shouldReceive('getClientKey')
                 ->andReturn('mock-client-key-12345');
        });

        // 6. Act: Send checkout process request
        $response = $this->actingAs($customer)
            ->post(route('checkout.process'), [
                'product_id' => $product->id,
                'check_in' => now()->addDays(1)->format('Y-m-d'),
                'check_out' => now()->addDays(1)->format('Y-m-d'),
                'quantity' => 2,
                'guests' => 2,
                'notes' => 'Tolong siapkan life jacket ukuran XL.',
            ]);

        // 7. Assert: Response is successful and renders the payment view
        $response->assertStatus(200);
        $response->assertViewIs('frontend.payment');
        $response->assertViewHas('snapToken', 'mocked-snap-token-12345');

        // 8. Assert: Transaction was recorded in the database
        $this->assertDatabaseHas('transactions', [
            'user_id' => $customer->id,
            'product_id' => $product->id,
            'vendor_id' => $vendor->id,
            'quantity' => 2,
            'status' => 'pending',
            'payment_method' => 'midtrans',
        ]);

        // 9. Assert: Product stock was decremented (10 - 2 = 8)
        $this->assertEquals(8, $product->fresh()->stock);

        // 10. Assert: OrderCreatedMail was queued to the customer
        Mail::assertQueued(\App\Mail\OrderCreatedMail::class, function ($mail) use ($customer) {
            return $mail->hasTo($customer->email);
        });
    }
}
