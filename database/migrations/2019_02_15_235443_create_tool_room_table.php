<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateToolRoomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tool_room', function (Blueprint $table) {
            $table->increments('id');
            //Foreign Key to Tool
            $table->unsignedInteger('id_tool');
            $table->foreign('id_tool')->references('id')->on('tool');
            //Foreign Key to Room
            $table->unsignedInteger('id_room');
            $table->foreign('id_room')->references('id')->on('room');
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
        Schema::dropIfExists('tool_room');
    }
}
