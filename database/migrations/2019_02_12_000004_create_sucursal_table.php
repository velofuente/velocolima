<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSucursalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sucursal', function (Blueprint $table) {
            // $table->increments('id');
            // $table->string('nombre');
            // $table->string('domicilio');
            // $table->string('municipio');
            // $table->string('estado');
            // $table->tinyInteger('telefono');
            // $table->timestamps();

            //TODO: CHANGE THE NAME OF THE MIGRATION FILE
            $table->increments('id');
            $table->string('name');
            $table->string('address');
            $table->string('municipality');
            $table->string('state');
            $table->tinyInteger('phone');
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
        Schema::dropIfExists('sucursal');
    }
}
