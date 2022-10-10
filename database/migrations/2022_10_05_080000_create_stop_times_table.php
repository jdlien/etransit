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
        Schema::create('stop_times', function (Blueprint $table) {
            $table->string('trip_id', 36); // trip_id in GTFS references trips.id
            $table->string('arrival_time', 8); // arrival_time in GTFS
            $table->string('departure_time', 8); // departure_time in GTFS
            $table->string('stop_id', 36); // stop_id in GTFS references stops.id
            $table->unsignedInteger('stop_sequence'); // stop_sequence in GTFS
            $table->string('stop_headsign', 255)->nullable(); // stop_headsign in GTFS
            $table->enum('pickup_type', [
                0, // Regularly scheduled pickup
                1, // No pickup available
                2, // Must phone agency to arrange pickup
                3, // Must coordinate with driver to arrange pickup
            ])->nullable(); // pickup_type in GTFS
            $table->enum('drop_off_type', [
                0, // Regularly scheduled drop off
                1, // No drop off available
                2, // Must phone agency to arrange drop off
                3, // Must coordinate with driver to arrange drop off
            ])->nullable(); // drop_off_type in GTFS
            $table->enum('continuous_pickup', [
                0, // Continuous stopping pickup
                1, // (or empty) No continuous stopping pickup
                2, // Must phone agency to arrange continuous stopping pickup
                3, // Must coordinate with driver to arrange continuous stopping pickup
            ])->nullable();
            $table->enum('continuous_drop_off', [
                0, // Continuous stopping drop off
                1, // (or empty) No continuous stopping drop off
                2, // Must phone agency to arrange continuous stopping drop off
                3, // Must coordinate with driver to arrange continuous stopping drop off
            ])->nullable();
            $table->decimal('shape_dist_traveled', 9, 6)->nullable(); // shape_dist_traveled in GTFS
            $table->enum('timepoint', [
                '0', // Times are considered approximate
                '1', // Times are considered exact
            ])->nullable(); // timepoint in GTFS
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stop_times');
    }
};
