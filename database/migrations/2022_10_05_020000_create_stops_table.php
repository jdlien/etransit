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
        Schema::create('location_types', function (Blueprint $table) {
            $table->unsignedTinyInteger('id')->primary(); // Referenced by stops.location_type_id
            $table->string('name');
            $table->string('description');
        });

        // The default GTFS route types
        DB::table('location_types')->insert([
            ['id' => 0, 'name' => 'Stop/Platform', 'description' => 'A location where passengers board or disembark from a transit vehicle. Is called a platform when defined within a parent_station.'],
            ['id' => 1, 'name' => 'Station', 'description' => 'A physical structure or area that contains one or more stop.'],
            ['id' => 2, 'name' => 'Entrance/Exit', 'description' => 'A location where passengers can enter or exit a station from the street. The stop entry must also specify a parent_station value referencing the stop ID of the station where the entrance/exit is located.'],
            ['id' => 3, 'name' => 'Generic Node', 'description' => 'A location within a station, not matching any other location_type, which can be used to link together pathways defined in pathways.txt.'],
            ['id' => 4, 'name' => 'Boarding Area', 'description' => 'A specific location on a platform, where passengers can board or disembark from a transit vehicle.'],
        ]);

        // See https://gtfs.org/schedule/reference/#stopstxt
        Schema::create('stops', function (Blueprint $table) {
            $table->string('id', 36)->primary(); // stop_id in GTFS
            $table->string('code', 36)->nullable(); // stop_code in GTFS
            $table->string('name')->nullable(); // stop_name in GTFS
            $table->string('tts_name')->nullable(); // for text-to-speech engines - stop_tts_name in GTFS
            $table->string('description', 1024)->nullable(); // stop_desc in GTFS
            $table->decimal('lat', 9, 6)->nullable(); // stop_lat in GTFS
            $table->decimal('lon', 9, 6)->nullable(); // stop_lon in GTFS
            $table->string('zone_id', 36)->nullable();
            $table->string('url', 1024)->nullable(); // stop_url in GTFS
            // $table->foreignId('location_type_id')->references('id')->on('location_types'); // location_type
            $table->unsignedTinyInteger('location_type_id')->nullable(); // location_type in GTFS (references location_types.id)
            $table->string('parent_station', 36)->nullable(); // Foreign ID referencing stops.id
            $table->string('timezone', 100)->nullable(); // stop_timezone in GTFS
            $table->enum('wheelchair_boarding', [
                '0', // No information
                '1', // Possible
                '2', // Not possible
            ])->nullable(); // wheelchair_boarding in GTFS
            $table->string('level_id', 36)->nullable();
            $table->string('platform_code', 36)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stops');
    }
};
