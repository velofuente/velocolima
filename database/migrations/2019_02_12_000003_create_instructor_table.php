<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstructorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instructor', function (Blueprint $table) {
            // $table->increments('id');
            // $table->string('nombre');
            // $table->string('apellido_p');
            // $table->string('apellido_m');
            // $table->string('email');
            // $table->integer('telefono');
            // $table->date('fecha_nac');
            // $table->timestamps();

            //TODO: CHANGE THE NAME OF THE MIGRATION FILE
            $table->increments('id');
            $table->string('name');
            $table->string('last_name'); //Changed "apellido_p/m" to "last_name"
            $table->string('email');
            $table->string('phone'); //Changed data type from "integer" to "string"
            $table->date('date_birth');
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
        Schema::dropIfExists('instructor');
    }
}
