<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule', function (Blueprint $table) {
            $table->increments('id');
            $table->date('day');
            $table->time('hour');
            //Foreign Key from Schedule to Instructor
            $table->unsignedInteger('id_instructor');
            $table->foreign('id_instructor')->references('id')->on('instructor');
            //Foreign Key from Schedule to Class
            $table->unsignedInteger('id_class');
            $table->foreign('id_class')->references('id')->on('class');
            //Foreign Key from Schedule to Room
            $table->unsignedInteger('id_room');
            $table->foreign('id_room')->references('id')->on('room');

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
        Schema::dropIfExists('schedule');
    }
}
