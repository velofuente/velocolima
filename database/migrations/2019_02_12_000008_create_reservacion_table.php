<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservacion', function (Blueprint $table) {
            // $table->increments('id');

            // //Llave Foránea a Usuario
            // $table->unsignedInteger('id_usuario');
            // $table->foreign('id_usuario')->references('id')->on('users');

            // //Llave Foránea a Horario
            // $table->unsignedInteger('id_horario');
            // $table->foreign('id_horario')->references('id')->on('horario');

            // $table->timestamps();

            //TODO: CHANGE THE NAME OF THE MIGRATION FILE
            $table->increments('id');

            //Foreign Key to table "users"
            $table->unsignedInteger('id_usuario');
            $table->foreign('id_usuario')->references('id')->on('users');

            //Foreign Key to table "horario"
            $table->unsignedInteger('id_horario');
            $table->foreign('id_horario')->references('id')->on('horario');

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
        Schema::dropIfExists('reservacion');
    }
}
