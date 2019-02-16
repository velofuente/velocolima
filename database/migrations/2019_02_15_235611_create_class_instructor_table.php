<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassInstructorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_instructor', function (Blueprint $table) {
            $table->increments('id');
            //Foreign Key to Class
            $table->unsignedInteger('id_class');
            $table->foreign('id_class')->references('id')->on('class');
            //Foreign Key to Instructor
            $table->unsignedInteger('id_instructor');
            $table->foreign('id_instructor')->references('id')->on('instructor');
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
        Schema::dropIfExists('class_instructor');
    }
}
