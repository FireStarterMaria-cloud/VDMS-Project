<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')
                  ->constrained('vehicles')
                  ->cascadeOnDelete();
            $table->foreignId('branch_id')
                  ->constrained('branches')
                  ->cascadeOnDelete();
            $table->foreignId('purchased_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();
            $table->string('supplier_name')->nullable();
            $table->string('supplier_contact')->nullable();
            $table->decimal('purchase_price', 15, 2);
            $table->enum('payment_method', [
                'cash',
                'cheque',
                'bank_transfer'
            ])->default('cash');
            $table->string('reference_no')->nullable();
            $table->date('purchase_date');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};