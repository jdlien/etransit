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
        Schema::create('trips', function (Blueprint $table) {
            $table->string('id', 36)->primary(); // trip_id in GTFS
            $table->string('route_id', 36); // route_id in GTFS references routes.id
            $table->string('service_id', 36); // service_id in GTFS references calendars.id or calendar_dates.id
            $table->string('headsign', 255)->nullable(); // trip_headsign in GTFS
            $table->string('short_name', 255)->nullable(); // trip_short_name in GTFS
            $table->enum('direction_id', [
                '0', // Outbound (one direction)
                '1', // Inbound (opposite direction)
            ])->nullable(); // direction_id in GTFS
            $table->string('block_id', 36)->nullable(); // block_id in GTFS
            $table->string('shape_id', 36)->nullable(); // shape_id in GTFS references shapes.id
            $table->enum('wheelchair_accessible', [
                '0', // No accessibility information for the trip
                '1', // Vehicle being used on this particular trip can accommodate at least one rider in a wheelchair
                '2', // No riders in wheelchairs can be accommodated on this trip
            ])->nullable(); // wheelchair_accessible in GTFS
            $table->enum('bikes_allowed', [
                '0', // No bike information for the trip
                '1', // Vehicle being used on this particular trip can accommodate at least one bicycle
                '2', // No bicycles are allowed on this trip
            ])->nullable(); // bikes_allowed in GTFS
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trips');
    }
};
