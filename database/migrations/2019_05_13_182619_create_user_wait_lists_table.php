<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserWaitListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_wait_lists', function (Blueprint $table) {
            $table->increments('id');
            //Foreign Key to User
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            //Foreign Key to Wait list
            $table->unsignedInteger('wait_list_id');
            $table->foreign('wait_list_id')->references('id')->on('wait_lists');
            $table->boolean('status');
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
        Schema::dropIfExists('user_wait_lists');
    }
}
