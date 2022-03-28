<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFranchisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('franchises', function (Blueprint $table) {
            $table->increments('id');
            $table->string('bussines_name');
            $table->string('address');
            $table->integer('int_number');
            $table->string('ext_number', 7)->default('');
            $table->string('legal_representative', 150);
            $table->string('municipality', 100);
            $table->string('country', 100);
            $table->string('postal_code', 5);
            $table->string('phone', 14)->nullable();
            $table->string('email')->nullable();
            $table->boolean('active')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('franchises');
    }
}
