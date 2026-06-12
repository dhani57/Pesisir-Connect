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
        Schema::create('vendor_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->constrained('vendors')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('transaction_id')->constrained('transactions')->cascadeOnDelete();
            $table->unsignedTinyInteger('rating');              // 1-5
            $table->text('review_text')->nullable();
            $table->integer('helpful_count')->default(0);
            $table->boolean('is_hidden')->default(false);
            $table->text('vendor_reply')->nullable();
            $table->timestamp('vendor_reply_at')->nullable();
            $table->timestamps();

            $table->index('vendor_id');
            $table->index('rating');
            $table->index(['vendor_id', 'is_hidden']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_reviews');
    }
};
