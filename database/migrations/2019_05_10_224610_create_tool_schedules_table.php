<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateToolSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tool_schedules', function (Blueprint $table) {
            $table->increments('id');
            //Foreign Key from Purchase to tool
            $table->unsignedInteger('tool_id');
            $table->foreign('tool_id')->references('id')->on('tools');
            //Foreign Key from Purchase to schedules
            $table->unsignedInteger('schedule_id');
            $table->foreign('schedule_id')->references('id')->on('schedules');
            //selected
            $table->boolean('selected');
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
        Schema::dropIfExists('tool_schedules');
    }
}
