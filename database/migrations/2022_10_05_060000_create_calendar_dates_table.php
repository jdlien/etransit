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
        /**
         * calendar.txt is conditionally required and these can be used
         * as a foreign key to the calendar_dates.txt file.
         *
         * Edmonton Transit Service does not use this table.
         *
         * See https://gtfs.org/schedule/reference/#calendartxt
         */
        Schema::create('calendars', function (Blueprint $table) {
            $table->string('id', 36)->primary(); // service_id in GTFS
            $table->boolean('monday');
            $table->boolean('tuesday');
            $table->boolean('wednesday');
            $table->boolean('thursday');
            $table->boolean('friday');
            $table->boolean('saturday');
            $table->boolean('sunday');
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();
        });

        Schema::create('calendar_dates', function (Blueprint $table) {
            $table->id(); // Auto-generated primary key
            $table->string('service_id', 36); // service_id Is not a primary key if referencing calendars.id (service_id)
            $table->date('date');
            // Can use exception_type mod 1 to convert tinyint to boolean (eg 2 becomes 0)
            $table->boolean('exception_type'); // Valid options are "1 - Service added" and "2 - Service removed (we will map 0 or false to this)"
            $table->unique(['service_id', 'date']);
            $table->index('service_id');
            $table->index('date');
            // Should we create a composite index?
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calendar_dates');
        Schema::dropIfExists('calendars');
    }
};
