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
        Schema::table('transactions', function (Blueprint $table) {
            $table->foreignId('vendor_id')->nullable()->after('product_id')
                  ->constrained('vendors')->nullOnDelete();
            $table->string('vendor_status', 50)->default('pending')->after('status'); // pending, ready, completed, cancelled
            $table->timestamp('completed_at')->nullable()->after('paid_at');

            $table->index('vendor_id');
            $table->index('vendor_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['vendor_id']);
            $table->dropIndex(['vendor_id']);
            $table->dropIndex(['vendor_status']);
            $table->dropColumn(['vendor_id', 'vendor_status', 'completed_at']);
        });
    }
};
