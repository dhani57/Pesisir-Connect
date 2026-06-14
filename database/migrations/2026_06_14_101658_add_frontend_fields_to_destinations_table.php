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
        Schema::table('destinations', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('name');
            $table->string('tagline')->nullable()->after('slug');
            $table->json('highlights')->nullable()->after('description');
            $table->decimal('rating', 3, 1)->default(0)->after('highlights');
            $table->integer('reviews')->default(0)->after('rating');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('destinations', function (Blueprint $table) {
            $table->dropColumn(['slug', 'tagline', 'highlights', 'rating', 'reviews']);
        });
    }
};
