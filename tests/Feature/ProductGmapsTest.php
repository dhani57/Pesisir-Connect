<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductGmapsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test coordinate parsing from Google Maps links.
     */
    public function test_coordinate_parsing_from_gmaps_links()
    {
        // 1. Test standard URL with @latitude,longitude
        $url1 = 'https://www.google.com/maps/place/Krui,+Pesisir+Barat+Regency,+Lampung/@-5.1873428,103.8827941,13z/data=!3m1!4b1';
        $coords1 = Product::parseGoogleMapsLink($url1);
        $this->assertNotNull($coords1);
        $this->assertEquals('-5.1873428', $coords1['latitude']);
        $this->assertEquals('103.8827941', $coords1['longitude']);

        // 2. Test query parameter URL
        $url2 = 'https://maps.google.com/?q=-5.1873428,103.8827941';
        $coords2 = Product::parseGoogleMapsLink($url2);
        $this->assertNotNull($coords2);
        $this->assertEquals('-5.1873428', $coords2['latitude']);
        $this->assertEquals('103.8827941', $coords2['longitude']);

        // 3. Test path coordinate URL
        $url3 = 'https://www.google.com/maps/place/-5.1873428,103.8827941';
        $coords3 = Product::parseGoogleMapsLink($url3);
        $this->assertNotNull($coords3);
        $this->assertEquals('-5.1873428', $coords3['latitude']);
        $this->assertEquals('103.8827941', $coords3['longitude']);

        // 4. Test shortened/redirect URL requiring HTML meta tag scraping
        $url4 = 'https://maps.app.goo.gl/L5FbThFU5aV87KJ56';
        $coords4 = Product::parseGoogleMapsLink($url4);
        $this->assertNotNull($coords4);
        $this->assertEqualsWithDelta(-5.2498362, floatval($coords4['latitude']), 0.001);
        $this->assertEqualsWithDelta(103.9690518, floatval($coords4['longitude']), 0.001);
    }

    /**
     * Test storing product with Google Maps link extracts coordinates.
     */
    public function test_vendor_can_create_product_with_gmaps_link()
    {
        $vendorUser = User::factory()->create(['role' => 'vendor']);
        $vendor = Vendor::create([
            'user_id' => $vendorUser->id,
            'shop_name' => 'Gmaps Test Vendor',
            'status' => 'approved',
            'is_approved' => true,
        ]);

        $category = Category::create([
            'name' => 'Sewa Kayak',
            'slug' => 'sewa-kayak',
            'description' => 'Sewa Kayak Test',
        ]);

        $response = $this->actingAs($vendorUser)
            ->post(route('vendor.products.store'), [
                'name' => 'Kayak Adventure',
                'sku' => 'KYK-001',
                'category_id' => $category->id,
                'description' => 'Kayak adventure detailed description',
                'short_description' => 'Short kayak description',
                'price' => 150000,
                'price_unit' => 'jam',
                'stock' => 5,
                'location' => 'Krui',
                'gmaps_link' => 'https://www.google.com/maps/place/Krui,+Pesisir+Barat+Regency,+Lampung/@-5.1873428,103.8827941,13z',
                'thumbnail_url' => 'https://placehold.co/800x600/0ea5e9/ffffff?text=Thumbnail',
            ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('vendor.products.index'));

        $this->assertDatabaseHas('products', [
            'name' => 'Kayak Adventure',
            'sku' => 'KYK-001',
            'gmaps_link' => 'https://www.google.com/maps/place/Krui,+Pesisir+Barat+Regency,+Lampung/@-5.1873428,103.8827941,13z',
            'latitude' => -5.1873428,
            'longitude' => 103.8827941,
        ]);
    }
}
