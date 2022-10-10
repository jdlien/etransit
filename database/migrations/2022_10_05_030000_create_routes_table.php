<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('route_types', function (Blueprint $table) {
            $table->unsignedTinyInteger('id')->primary(); // Referenced by routes.route_type_id
            $table->string('name');
            $table->string('description');
        });

        // The default GTFS route types
        DB::table('route_types')->insert([
            ['id' => 0, 'name' => 'Tram, Streetcar, Light rail', 'description' => 'Any light rail or street level system within a metropolitan area.'],
            ['id' => 1, 'name' => 'Subway, Metro', 'description' => 'Any underground rail system within a metropolitan area.'],
            ['id' => 2, 'name' => 'Rail', 'description' => 'Used for intercity or long-distance travel.'],
            ['id' => 3, 'name' => 'Bus', 'description' => 'Used for short- and long-distance bus routes.'],
            ['id' => 4, 'name' => 'Ferry', 'description' => 'Used for short- and long-distance boat service.'],
            ['id' => 5, 'name' => 'Cable car', 'description' => 'Used for street-level cable cars where the cable runs beneath the car.'],
            ['id' => 6, 'name' => 'Gondola, Suspended cable car', 'description' => 'Used for aerial cable cars where the car is suspended from the cable.'],
            ['id' => 7, 'name' => 'Funicular', 'description' => 'Any rail system designed for steep inclines.'],
            ['id' => 11, 'name' => 'Trolleybus', 'description' => 'Electric buses that draw power from overhead wires using poles.'],
            ['id' => 12, 'name' => 'Monorail', 'description' => 'Railway in which the track consists of a single rail or a beam.'],
        ]);

        // Create the GTFS routes table
        // https://developers.google.com/transit/gtfs/reference/#routestxt
        Schema::create('routes', function(Blueprint $table) {
            $table->string('id', 36)->primary(); // route_id
            $table->string('agency_id', 36)->nullable(); // agency_id (may reference agencies.id)
            $table->string('short_name', 92)->nullable(); // route_short_name
            $table->string('long_name', 256)->nullable(); // route_long_name
            $table->string('description', 1024)->nullable(); // route_desc
            // UnsignedTinyInteger is more efficient, this is more straightforward if we want a foreign key constraint
            // $table->foreignId('route_type_id')->references('id')->on('route_types'); // route_type
            $table->unsignedTinyInteger('route_type_id'); // route_type (references route_types.id)
            $table->string('url', 1024)->nullable(); // route_url
            $table->string('color', 6)->nullable(); // route_color, six-digit hex code
            $table->string('text_color', 6)->nullable(); // route_text_color, six-digit hex code
            $table->unsignedInteger('sort_order')->nullable(); // route_sort_order
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
            $table->string('network_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('route_types');
    }
};
