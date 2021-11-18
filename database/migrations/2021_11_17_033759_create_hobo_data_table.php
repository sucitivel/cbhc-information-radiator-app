<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHoboDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('hobo')->create('hobo_data', function (Blueprint $table) {
            $table->id();
            $table->string('room_id');
            $table->dateTime('time');
            $table->float('celcius', 3, 2);
            $table->float('rh', 3, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('hobo')->dropIfExists('hobo_data');
    }
}
