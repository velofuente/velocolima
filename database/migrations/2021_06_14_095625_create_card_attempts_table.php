<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardAttemptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('card_attempts', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('card_number')->nullable(false)->unique();
            $table->integer('user_id')->nullable(false);
            $table->tinyInteger('attempts')->default(0);
            $table->date('date')->nullable(false);
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
        Schema::dropIfExists('card_attempts');
    }
}
