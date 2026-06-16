<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sync_queue', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')
                  ->nullable()
                  ->constrained('branches')
                  ->nullOnDelete();
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();
            $table->string('model_type')->nullable();
            $table->unsignedBigInteger('model_id')->nullable();
            $table->enum('operation', [
                'create',
                'update',
                'delete'
            ]);
            $table->json('payload')->nullable();
            $table->enum('status', [
                'pending',
                'synced',
                'failed',
                'conflict'
            ])->default('pending');
            $table->integer('retry_count')->default(0);
            $table->text('conflict_note')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('synced_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sync_queue');
    }
};