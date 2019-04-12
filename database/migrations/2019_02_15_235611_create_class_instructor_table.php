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
            $table->unsignedInteger('class_id');
            $table->foreign('class_id')->references('id')->on('classes');
            //Foreign Key to Instructor
            $table->unsignedInteger('instructor_id');
            $table->foreign('instructor_id')->references('id')->on('instructors');
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
