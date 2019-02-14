<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeporteInstructorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deporte-instructor', function (Blueprint $table) {
            // $table->increments('id');

            // //Llave Foránea a Instructor
            // $table->unsignedInteger('id_instructor');
            // $table->foreign('id_instructor')->references('id')->on('instructor');

            // //Llave Foránea a Deporte
            // $table->unsignedInteger('id_deporte');
            // $table->foreign('id_deporte')->references('id')->on('deporte');

            // $table->timestamps();

            //TODO: CHANGE THE NAME OF THE MIGRATION FILE
            $table->increments('id');
            //Foreign Key to table "instructor"
            $table->unsignedInteger('id_instructor');
            $table->foreign('id_instructor')->references('id')->on('instructor');
            //Foreign Key to table "deporte"
            $table->unsignedInteger('id_deporte');
            $table->foreign('id_deporte')->references('id')->on('deporte');
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
        Schema::dropIfExists('deporte-instructor');
    }
}
