<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHorarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('horario', function (Blueprint $table) {
            // $table->increments('id');
            // $table->date('dia');
            // $table->time('hora');
            // $table->tinyInteger('cupo');
            // //Llave Foránea a Instructor
            // $table->unsignedInteger('id_instructor');
            // $table->foreign('id_instructor')->references('id')->on('instructor');
            // //Llave Foránea a Deporte
            // $table->unsignedInteger('id_deporte');
            // $table->foreign('id_deporte')->references('id')->on('deporte');
            // //Llave Foránea a Sucursal
            // $table->unsignedInteger('id_sucursal');
            // $table->foreign('id_sucursal')->references('id')->on('sucursal');
            // $table->timestamps();

            //TODO: CHANGE THE NAME OF THE MIGRATION FILE
            $table->increments('id');
            $table->date('day');
            $table->time('hour');
            $table->tinyInteger('cupo'); //TODO: Search the meaning of "cupo"

            //Foreign Key to table "instructor"
            $table->unsignedInteger('id_instructor');
            $table->foreign('id_instructor')->references('id')->on('instructor');

            //Foreign Key to table "deporte"
            $table->unsignedInteger('id_deporte');
            $table->foreign('id_deporte')->references('id')->on('deporte');

            //Foreign Key to table "sucursal"
            $table->unsignedInteger('id_sucursal');
            $table->foreign('id_sucursal')->references('id')->on('sucursal');

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
        Schema::dropIfExists('horario');
    }
}
