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
            $table->increments('id');
            $table->string('nombre');
            $table->string('apellido_p');
            $table->string('apellido_m');
            $table->string('email');
            $table->integer('telefono');
            $table->date('fecha_nac');
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
