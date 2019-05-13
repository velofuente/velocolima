<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_schedules', function (Blueprint $table) {
            $table->increments('id');
            //Foreign Key to User
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            //Foreign Key to Schedule
            $table->unsignedInteger('schedule_id');
            $table->foreign('schedule_id')->references('id')->on('schedules');
            //Foreign Key to Purchase
            $table->unsignedInteger('purchase_id');
            $table->foreign('purchase_id')->references('id')->on('purchases');
            $table->integer('bike');
            /*
            //Foreign Key to toolSchedule
            $table->unsignedInteger('tool_schedule_id');
            $table->foreign('tool_schedule_id')->references('id')->on('tool_schedules');
            */
            //If false = canceled
            $table->boolean('status');
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
        Schema::dropIfExists('user_schedules');
    }
}
