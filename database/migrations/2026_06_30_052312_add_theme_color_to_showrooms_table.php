<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('showrooms', function (Blueprint $table) {
        $table->string('theme_color')->default('#696cff')->after('logo');
    });
}

public function down(): void
{
    Schema::table('showrooms', function (Blueprint $table) {
        $table->dropColumn('theme_color');
    });
}
};
