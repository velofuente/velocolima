<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->increments('id');
            //Foreign Key from Purchase to Cards
            $table->unsignedInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products');
            //Foreign Key from Purchase to Cards
            $table->unsignedInteger('card_id');
            $table->foreign('card_id')->references('id')->on('cards');
            //Foreign Key from Purchase to Users
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            //Data obtained from the product
            $table->string('n_classes');
            $table->integer('expiration_days');
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
        Schema::dropIfExists('purchases');
    }
}
