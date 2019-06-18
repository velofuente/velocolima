<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDeleteProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('instructors', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('branches', function (Blueprint $table) {
            $table->tinyInteger('reserv_lim_x');
            $table->tinyInteger('reserv_lim_y');
            $table->softDeletes();
        });
        Schema::table('schedules', function (Blueprint $table) {
            //Foreign Key from Schedule to Branch
            $table->unsignedInteger('branch_id');
            $table->foreign('branch_id')->references('id')->on('branches');
            $table->softDeletes();
        });
        Schema::table('tools', function (Blueprint $table) {
            //Foreign Key to Schedule
            $table->unsignedInteger('branch_id');
            $table->foreign('branch_id')->references('id')->on('branches');
        });
        Schema::table('users', function (Blueprint $table) {
            //Foreign Key from User to Branch
            $table->unsignedInteger('branch_id')->nullable();
            $table->foreign('branch_id')->references('id')->on('branches');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}