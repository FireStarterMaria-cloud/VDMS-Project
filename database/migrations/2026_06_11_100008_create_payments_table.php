<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')
                  ->constrained('sales')
                  ->cascadeOnDelete();
            $table->foreignId('branch_id')
                  ->constrained('branches')
                  ->cascadeOnDelete();
            $table->foreignId('received_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();
            $table->decimal('amount', 15, 2);
            $table->string('currency', 10)->default('PKR');
            $table->decimal('exchange_rate', 10, 6)->default(1);
            $table->enum('payment_method', [
                'cash',
                'cheque',
                'bank_transfer',
                'stripe',
                'jazzcash'
            ])->default('cash');
            $table->string('reference_no')->nullable();
            $table->enum('status', [
                'pending',
                'completed',
                'failed',
                'refunded'
            ])->default('pending');
            $table->date('payment_date');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};