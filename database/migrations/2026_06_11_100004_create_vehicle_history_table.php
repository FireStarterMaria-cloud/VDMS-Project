<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicle_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')
                  ->constrained('vehicles')
                  ->cascadeOnDelete();
            $table->foreignId('performed_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();
            $table->enum('action', [
                'purchased',
                'transferred',
                'reserved',
                'sold',
                'status_changed'
            ]);
            $table->text('description')->nullable();
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->foreignId('from_branch_id')
                  ->nullable()
                  ->constrained('branches')
                  ->nullOnDelete();
            $table->foreignId('to_branch_id')
                  ->nullable()
                  ->constrained('branches')
                  ->nullOnDelete();
            $table->timestamp('performed_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicle_history');
    }
};