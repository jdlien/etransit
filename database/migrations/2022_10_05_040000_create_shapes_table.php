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
        Schema::create('shapes', function (Blueprint $table) {
            $table->string('id', 36)->primary(); // shape_id in GTFS
            $table->decimal('pt_lat', 9, 6); // Latitude of a shape point
            $table->decimal('pt_lon', 9, 6); // Longitude of a shape point
            $table->unsignedInteger('pt_sequence'); // Sequence in which the shape points connect to form the shape
            $table->decimal('dist_traveled', 9, 6)->nullable(); // Actual distance traveled along the shape from the first shape point to the point specified in this record
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shapes');
    }
};
