<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('apellido_p');
            $table->string('apellido_m');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->date('fecha_nac');
            $table->tinyInteger('telefono')->unsigned();
            $table->float('peso', 5,2);
            $table->tinyInteger('estatura')->unsigned();
            $table->tinyInteger('n_clases')->unsigned();
            $table->date('expiracion');
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
