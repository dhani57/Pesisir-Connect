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
        Schema::create('vendor_commission_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->constrained('vendors')->cascadeOnDelete();
            $table->foreignId('transaction_id')->constrained('transactions')->cascadeOnDelete();
            $table->decimal('amount', 15, 2);                // Transaction amount
            $table->decimal('commission_percentage', 5, 2);   // Rate at the time
            $table->decimal('commission_amount', 15, 2);      // Commission taken
            $table->decimal('vendor_earning', 15, 2);         // Net earning for vendor
            $table->date('period_start')->nullable();
            $table->date('period_end')->nullable();
            $table->string('status', 50)->default('calculated'); // calculated, paid, failed
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->index('vendor_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_commission_logs');
    }
};
