<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDealProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deal_product', function (Blueprint $table) {
            $table->increments('id');
            //Foreign Key to Deal
            $table->unsignedInteger('id_deal');
            $table->foreign('id_deal')->references('id')->on('deal');
            //Foreign Key to Product
            $table->unsignedInteger('id_product');
            $table->foreign('id_product')->references('id')->on('product');
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
        Schema::dropIfExists('deal_product');
    }
}
