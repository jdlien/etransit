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
        Schema::create('transfers', function (Blueprint $table) {
            $table->string('from_stop_id', 36)->nullable(); // from_stop_id in GTFS references stops.id')
            $table->string('to_stop_id', 36)->nullable(); // to_stop_id in GTFS references stops.id')
            $table->string('from_route_id', 36)->nullable(); // from_route_id in GTFS references routes.id')
            $table->string('to_route_id', 36)->nullable(); // to_route_id in GTFS references routes.id')
            $table->string('from_trip_id', 36)->nullable(); // from_trip_id in GTFS references trips.id')
            $table->string('to_trip_id', 36)->nullable(); // to_trip_id in GTFS references trips.id')
            $table->enum('transfer_type', [
                0, // Recommended transfer point between two routes
                1, // Timed transfer point between two routes
                2, // Transfer requires a minimum amount of time between arrival and departure to ensure a connection. The time required to transfer is specified by min_transfer_time.
                3, // Transfers are not possible between routes at the location.
                4, // Passengers can transfer from one trip to another by staying onboard the same vehicle (an "in-seat transfer").
                5, // In-seat transfers are not allowed between sequential trips. The passenger must alight from the vehicle and re-board.
            ])->default(0); // Indicates the type of connection for the specified (from_stop_id, to_stop_id) pair
            $table->unsignedInteger('min_transfer_time')->nullable(); // Minimum amount of time in seconds that must be available in an itinerary to permit a transfer between routes at these stops.
            // The min_transfer_time must be sufficient to permit a typical rider to move between the two stops, including buffer time to allow for schedule variance on each route.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transfers');
    }
};
