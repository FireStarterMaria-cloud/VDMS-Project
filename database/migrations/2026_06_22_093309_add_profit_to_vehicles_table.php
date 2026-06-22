<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->decimal('profit_amount', 15, 2)->nullable()->after('selling_price');
            $table->enum('profit_type', ['profit', 'loss', 'break_even'])->nullable()->after('profit_amount');
            $table->date('purchase_date')->nullable()->after('purchase_price');
            $table->string('purchase_day')->nullable()->after('purchase_date');
        });
    }

    public function down()
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn(['profit_amount', 'profit_type', 'purchase_date', 'purchase_day']);
        });
    }
};