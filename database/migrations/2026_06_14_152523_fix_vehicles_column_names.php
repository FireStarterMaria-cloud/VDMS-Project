<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixVehiclesColumnNames extends Migration
{
    public function up()
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->renameColumn('registration_no', 'registration_number');
            $table->renameColumn('chassis_no', 'vin_number');
            $table->renameColumn('description', 'notes');
            $table->string('engine_capacity')->nullable()->after('fuel_type');
            $table->enum('condition', ['new', 'used'])->default('used')->after('notes');
        });
    }

    public function down()
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->renameColumn('registration_number', 'registration_no');
            $table->renameColumn('vin_number', 'chassis_no');
            $table->renameColumn('notes', 'description');
            $table->dropColumn(['engine_capacity', 'condition']);
        });
    }
}