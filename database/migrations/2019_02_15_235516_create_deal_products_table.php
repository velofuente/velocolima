<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDealProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deal_products', function (Blueprint $table) {
            $table->increments('id');
            //Foreign Key to Deal
            $table->unsignedInteger('id_deals');
            $table->foreign('id_deals')->references('id')->on('deals');
            //Foreign Key to Product
            $table->unsignedInteger('id_products');
            $table->foreign('id_products')->references('id')->on('products');
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
        Schema::dropIfExists('deal_products');
    }
}
