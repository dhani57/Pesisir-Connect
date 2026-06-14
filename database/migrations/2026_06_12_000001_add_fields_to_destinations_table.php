<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Adds slug, tagline, highlights, rating, reviews count,
     * sort_order, and is_active to the destinations table for
     * the dynamic frontend destinasi page.
     */
    public function up(): void
    {
        Schema::table('destinations', function (Blueprint $table) {
            $table->string('slug')->unique()->after('name');
            $table->string('tagline')->nullable()->after('location');
            $table->json('highlights')->nullable()->after('description');
            $table->decimal('rating', 2, 1)->default(0)->after('highlights');
            $table->unsignedInteger('reviews_count')->default(0)->after('rating');
            $table->unsignedInteger('sort_order')->default(0)->after('reviews_count');
            $table->boolean('is_active')->default(true)->after('sort_order');

            $table->index('is_active');
            $table->index('sort_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('destinations', function (Blueprint $table) {
            $table->dropIndex(['is_active']);
            $table->dropIndex(['sort_order']);
            $table->dropColumn([
                'slug', 'tagline', 'highlights', 'rating',
                'reviews_count', 'sort_order', 'is_active',
            ]);
        });
    }
};
