<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sub_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subscription_id')
                  ->constrained('subscriptions')
                  ->cascadeOnDelete();
            $table->foreignId('branch_id')
                  ->constrained('branches')
                  ->cascadeOnDelete();
            $table->string('transaction_id')->nullable();
            $table->enum('payment_method', [
                'stripe',
                'jazzcash',
                'bank_transfer'
            ])->default('bank_transfer');
            $table->decimal('amount', 15, 2);
            $table->string('currency', 10)->default('PKR');
            $table->enum('status', [
                'pending',
                'completed',
                'failed',
                'refunded'
            ])->default('pending');
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sub_payments');
    }
};