<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Monolog\Handler\BrowserConsoleHandler;

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
            $table->string('name', 60);
            $table->string('last_name', 40);
            $table->string('gender', 6);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->date('birth_date');
            $table->string('phone', 15);
            $table->float('weight', 5,2);
            $table->tinyInteger('height')->unsigned();
            $table->string('share_code',8);
            //Foreign Key from Users to Role
            $table->unsignedInteger('role_id')->default('3');
            $table->foreign('role_id')->references('id')->on('roles');
            $table->string('costumer_id')->nullable();

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
