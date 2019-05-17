<?php

use Illuminate\Database\Seeder;
use App\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*$product = new Product();
        $product->n_classes = 1;
        $product->price = 0.00;
        $product->description = "Clase Prueba";
        $product->expiration_days = 7;
        $product->save();*/

        $product = new Product();
        $product->n_classes = 1;
        $product->price = 130;
        $product->description = "1 clase";
        $product->expiration_days = 30;
        $product->type = "Packages";
        $product->status = 1;
        $product->save();

        $product = new Product();
        $product->n_classes = 5;
        $product->price = 625;
        $product->description = "5 clases";
        $product->expiration_days = 60;
        $product->type = "Packages";
        $product->status = 1;
        $product->save();

        $product = new Product();
        $product->n_classes = 10;
        $product->price = 1200;
        $product->description = "10 clases";
        $product->expiration_days = 120;
        $product->type = "Packages";
        $product->status = 1;
        $product->save();

        $product = new Product();
        $product->n_classes = 25;
        $product->price = 2700;
        $product->description = "25 clases";
        $product->expiration_days = 180;
        $product->type = "Packages";
        $product->status = 1;
        $product->save();

        $product = new Product();
        $product->n_classes = 50;
        $product->price = 4250;
        $product->description = "50 clases";
        $product->expiration_days = 365;
        $product->type = "Packages";
        $product->status = 1;
        $product->save();

        $product = new Product();
        $product->n_classes = 1;
        $product->price = 0;
        $product->description = "Clase gratis por ser nuevo cliente";
        $product->expiration_days = 30;
        $product->type = "Deals";
        $product->status = 1;
        $product->save();
    }
}
