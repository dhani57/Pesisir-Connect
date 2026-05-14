<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete();             // Vendor pemilik produk
            $table->foreignId('category_id')
                  ->constrained()
                  ->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('short_description')->nullable();
            $table->decimal('price', 12, 2);       // Harga dalam Rupiah
            $table->string('price_unit')->default('malam'); // malam, jam, set, trip
            $table->string('location');             // Pahawang, Krui, Teluk Kiluan
            $table->string('address')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('thumbnail')->nullable();
            $table->json('gallery')->nullable();    // Array of image paths
            $table->integer('capacity')->nullable(); // Kapasitas (penumpang perahu / tamu homestay)
            $table->json('facilities')->nullable();  // Fasilitas (AC, WiFi, etc)
            $table->string('whatsapp', 20)->nullable(); // WhatsApp vendor
            $table->decimal('rating', 3, 2)->default(0);
            $table->integer('total_reviews')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index(['category_id', 'is_active']);
            $table->index(['location', 'is_active']);
            $table->index('is_featured');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
