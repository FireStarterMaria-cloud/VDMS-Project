<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')
                  ->constrained('sales')
                  ->cascadeOnDelete();
            $table->foreignId('branch_id')
                  ->constrained('branches')
                  ->cascadeOnDelete();
            $table->foreignId('generated_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();
            $table->string('invoice_no')->unique();
            $table->decimal('subtotal', 15, 2);
            $table->decimal('tax', 15, 2)->default(0);
            $table->decimal('discount', 15, 2)->default(0);
            $table->decimal('total_amount', 15, 2);
            $table->string('currency', 10)->default('PKR');
            $table->enum('status', [
                'draft',
                'issued',
                'paid',
                'cancelled'
            ])->default('draft');
            $table->date('issue_date');
            $table->date('due_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};