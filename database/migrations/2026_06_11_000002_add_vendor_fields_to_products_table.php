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
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('vendor_id')->nullable()->after('user_id')
                  ->constrained('vendors')->nullOnDelete();
            $table->string('sku', 100)->nullable()->after('slug');
            $table->string('status', 50)->default('active')->after('is_active'); // active, inactive, draft
            $table->integer('min_stock_alert')->default(10)->after('status');
            $table->string('meta_title')->nullable()->after('min_stock_alert');
            $table->text('meta_description')->nullable()->after('meta_title');
            $table->string('meta_keywords')->nullable()->after('meta_description');
            $table->decimal('discount', 12, 2)->default(0)->after('price');
            $table->string('discount_type', 20)->default('percentage')->after('discount'); // percentage, fixed
            $table->integer('stock')->default(0)->after('capacity');

            $table->index('vendor_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['vendor_id']);
            $table->dropIndex(['vendor_id']);
            $table->dropIndex(['status']);
            $table->dropColumn([
                'vendor_id', 'sku', 'status', 'min_stock_alert',
                'meta_title', 'meta_description', 'meta_keywords',
                'discount', 'discount_type', 'stock',
            ]);
        });
    }
};
