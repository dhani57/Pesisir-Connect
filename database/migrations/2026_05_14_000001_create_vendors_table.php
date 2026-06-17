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
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                  ->unique()
                  ->constrained()
                  ->cascadeOnDelete();
            $table->string('shop_name')->unique();
            $table->string('business_type', 100)->nullable();
            $table->string('phone', 20)->nullable();
            $table->text('address')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('zip_code', 10)->nullable();
            $table->string('bank_name', 100)->nullable();
            $table->string('account_holder')->nullable();
            $table->string('account_number', 50)->nullable();
            $table->string('logo')->nullable();
            $table->string('avatar')->nullable();
            $table->text('bio')->nullable();
            $table->string('business_license')->nullable();        // Upload path
            $table->string('status', 50)->default('pending_approval'); // pending_approval, approved, suspended, deactivated
            $table->boolean('is_approved')->default(false);
            $table->timestamp('verified_at')->nullable();
            $table->decimal('commission_rate', 5, 2)->default(10); // percentage
            $table->decimal('total_earnings', 15, 2)->default(0);
            $table->integer('response_time_hours')->default(24);
            $table->boolean('auto_approve_orders')->default(false);
            $table->boolean('enable_notifications')->default(true);
            $table->json('notification_channels')->nullable();     // ['email', 'sms']
            $table->timestamps();

            $table->index('status');
            $table->index('is_approved');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
