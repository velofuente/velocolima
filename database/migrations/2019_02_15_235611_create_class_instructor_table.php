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
            $table->unsignedInteger('id_classes');
            $table->foreign('id_classes')->references('id')->on('classes');
            //Foreign Key to Instructor
            $table->unsignedInteger('id_instructors');
            $table->foreign('id_instructors')->references('id')->on('instructors');
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
