<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_schedule', function (Blueprint $table) {
            $table->increments('id');
            //Foreign Key to User
            $table->unsignedInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users');
            //Foreign Key to Schedule
            $table->unsignedInteger('id_schedule');
            $table->foreign('id_schedule')->references('id')->on('schedule');
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
        Schema::dropIfExists('user_schedule');
    }
}
