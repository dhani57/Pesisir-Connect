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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique(); // PC-20260514-XXXXX
            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete();                  // Customer yang memesan
            $table->foreignId('product_id')
                  ->constrained()
                  ->cascadeOnDelete();
            $table->foreignId('vendor_id')->nullable()
                  ->constrained('vendors')->nullOnDelete();
            $table->date('check_in');                    // Tanggal mulai
            $table->date('check_out');                   // Tanggal selesai
            $table->integer('quantity')->default(1);     // Jumlah unit
            $table->integer('guests')->default(1);       // Jumlah tamu/penumpang
            $table->decimal('unit_price', 12, 2);        // Harga satuan saat transaksi
            $table->decimal('total_price', 12, 2);       // Total harga
            $table->enum('status', [
                'pending',
                'paid',
                'confirmed',
                'completed',
                'cancelled',
                'refunded',
            ])->default('pending');
            $table->string('vendor_status', 50)->default('pending'); // pending, ready, completed, cancelled
            $table->enum('payment_method', [
                'midtrans',
                'bank_transfer',
                'cash',
            ])->default('midtrans');
            $table->string('midtrans_transaction_id')->nullable();
            $table->string('midtrans_payment_type')->nullable();
            $table->json('midtrans_response')->nullable(); // Raw response Midtrans
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->text('notes')->nullable();             // Catatan dari customer
            $table->text('vendor_notes')->nullable();      // Catatan dari vendor
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index(['product_id', 'status']);
            $table->index('status');
            $table->index('vendor_id');
            $table->index('vendor_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
