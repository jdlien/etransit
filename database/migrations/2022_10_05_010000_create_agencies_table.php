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
        Schema::create('agencies', function (Blueprint $table) {
            $table->string('id', 36)->primary(); // agency_id in GTFS
            $table->string('name');
            $table->string('url', 1024)->nullable();
            $table->string('phone', 16)->nullable();
            $table->string('fare_url', 1024)->nullable();
            $table->string('email', 254)->nullable();
            $table->string('lang', 15)->nullable();
            $table->string('timezone');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agencies');
    }
};
