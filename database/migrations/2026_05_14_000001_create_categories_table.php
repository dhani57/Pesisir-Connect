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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');               // Sewa Perahu, Alat Snorkeling, Homestay
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('icon')->nullable();    // Path ke icon/gambar kategori
            $table->string('image')->nullable();   // Hero image untuk kategori
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
