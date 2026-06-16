<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('branch_id')
                  ->references('id')
                  ->on('branches')
                  ->onDelete('set null')
                  ->onUpdate('cascade');
        });

        Schema::table('branches', function (Blueprint $table) {
            $table->foreign('manager_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['branch_id']);
        });

        Schema::table('branches', function (Blueprint $table) {
            $table->dropForeign(['manager_id']);
        });
    }
};