<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')
                  ->constrained('branches')
                  ->cascadeOnDelete();
            $table->foreignId('purchased_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();
            $table->string('make');
            $table->string('model');
            $table->integer('year');
            $table->string('registration_no')->unique()->nullable();
            $table->string('chassis_no')->unique()->nullable();
            $table->string('engine_no')->nullable();
            $table->string('colour')->nullable();
            $table->string('variant')->nullable();
            $table->enum('transmission', ['manual', 'automatic'])->default('manual');
            $table->enum('fuel_type', ['petrol', 'diesel', 'hybrid', 'electric'])->default('petrol');
            $table->integer('mileage')->default(0);
            $table->decimal('purchase_price', 15, 2)->default(0);
            $table->decimal('selling_price', 15, 2)->default(0);
            $table->enum('status', [
                'available',
                'sold',
                'in_transit',
                'reserved',
                'transferred'
            ])->default('available');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};