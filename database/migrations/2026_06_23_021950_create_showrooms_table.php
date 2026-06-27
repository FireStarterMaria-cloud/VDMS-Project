<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('showrooms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('city');
            $table->string('country')->default('Pakistan');
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('logo')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::table('branches', function (Blueprint $table) {
            $table->foreignId('showroom_id')->nullable()->after('id')->constrained('showrooms')->nullOnDelete();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('showroom_id')->nullable()->after('branch_id')->constrained('showrooms')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['showroom_id']);
            $table->dropColumn('showroom_id');
        });
        Schema::table('branches', function (Blueprint $table) {
            $table->dropForeign(['showroom_id']);
            $table->dropColumn('showroom_id');
        });
        Schema::dropIfExists('showrooms');
    }
};