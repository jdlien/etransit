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
        Schema::create('fare_attributes', function (Blueprint $table) {
            $table->string('id', 36)->primary(); // shape_id in GTFS
            $table->decimal('price', 9, 6); // Fare price in the unit specified by currency_type
            $table->string('currency_type', 3); // Currency used to pay the fare
            $table->enum('payment_method', [
                0, // Fare is paid on board
                1, // Fare must be paid before boarding
            ])->default(0); // Indicates when the fare must be paid
            $table->enum('transfers', [
                0, // No transfers permitted on this fare
                1, // Passenger may transfer once
                2, // Passenger may transfer twice
            ])->nullable(); // Number of transfers permitted on this fare. Empty means unlimited transfers are permitted.
            $table->string('agency_id', 36)->nullable(); // agency_id in GTFS references agencies.id
            $table->unsignedInteger('transfer_duration')->nullable(); // Length of time in seconds before a transfer expires
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fare_attributes');
    }
};
