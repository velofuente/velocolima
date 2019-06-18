<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddModifyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->float('shoe_size', 3,1)->nullable()->change();
            $table->string('share_code',8)->nullable()->change();
            $table->unsignedInteger('role_id')->change();
        });
        Schema::table('user_schedules', function (Blueprint $table) {
            $table->unsignedInteger('purchase_id')->nullable()->change();
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