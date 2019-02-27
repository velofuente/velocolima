<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->date('day');
            $table->time('hour');
            //Foreign Key from Schedule to Instructor
            $table->unsignedInteger('id_instructors');
            $table->foreign('id_instructors')->references('id')->on('instructors');
            //Foreign Key from Schedule to Class
            $table->unsignedInteger('id_classes');
            $table->foreign('id_classes')->references('id')->on('classes');
            //Foreign Key from Schedule to Room
            $table->unsignedInteger('id_rooms');
            $table->foreign('id_rooms')->references('id')->on('rooms');

            $table->tinyInteger('reservation_limit');
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
        Schema::dropIfExists('schedules');
    }
}
