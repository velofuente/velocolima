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
            $table->unsignedInteger('id_tools');
            $table->foreign('id_tools')->references('id')->on('tools');
            //Foreign Key to Room
            $table->unsignedInteger('id_rooms');
            $table->foreign('id_rooms')->references('id')->on('rooms');
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
