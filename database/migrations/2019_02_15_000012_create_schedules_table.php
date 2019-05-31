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
            $table->unsignedInteger('instructor_id');
            $table->foreign('instructor_id')->references('id')->on('instructors');
            //Foreign Key from Schedule to Class
            $table->unsignedInteger('class_id');
            $table->foreign('class_id')->references('id')->on('classes');
            $table->tinyInteger('reservation_limit');
            //Foreign Key from Schedule to Room
            $table->unsignedInteger('room_id');
            $table->foreign('room_id')->references('id')->on('rooms');
            $table->softDeletes();
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
