<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('branch_transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')
                  ->constrained('vehicles')
                  ->cascadeOnDelete();
            $table->foreignId('from_branch_id')
                  ->constrained('branches')
                  ->cascadeOnDelete();
            $table->foreignId('to_branch_id')
                  ->constrained('branches')
                  ->cascadeOnDelete();
            $table->foreignId('requested_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();
            $table->foreignId('approved_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();
            $table->enum('status', [
                'pending',
                'approved',
                'in_transit',
                'completed',
                'rejected'
            ])->default('pending');
            $table->text('reason')->nullable();
            $table->date('requested_date')->nullable();
            $table->date('approved_date')->nullable();
            $table->date('completed_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('branch_transfers');
    }
};