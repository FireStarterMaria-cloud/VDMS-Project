<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')
                  ->constrained('vehicles')
                  ->cascadeOnDelete();
            $table->foreignId('branch_id')
                  ->constrained('branches')
                  ->cascadeOnDelete();
            $table->foreignId('sold_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();
            $table->foreignId('customer_id')
                  ->constrained('customers')
                  ->cascadeOnDelete();
            $table->decimal('sale_price', 15, 2);
            $table->decimal('discount', 15, 2)->default(0);
            $table->decimal('final_price', 15, 2);
            $table->enum('status', [
                'pending',
                'completed',
                'cancelled'
            ])->default('pending');
            $table->date('sale_date');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};