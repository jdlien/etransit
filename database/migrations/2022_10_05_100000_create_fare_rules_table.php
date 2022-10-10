<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fare_rules', function (Blueprint $table) {
            $table->string('fare_id', 36); // fare_id in GTFS references fare_attributes.id
            $table->string('route_id', 36)->nullable(); // route_id in GTFS references routes.id
            $table->string('origin_id', 36)->nullable(); // origin_id in GTFS references stops.zone_id
            $table->string('destination_id', 36)->nullable(); // destination_id in GTFS references stops.zone_id
            $table->string('contains_id', 36)->nullable(); // contains_id in GTFS references stops.zone_id
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fare_rules');
    }
};
