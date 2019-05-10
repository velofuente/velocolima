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
        $schedule = new Product();
        $schedule->n_classes = 1;
        $schedule->price = 0.00;
        $schedule->description = "Clase Prueba";
        $schedule->expiration_days = 7;
        $schedule->save();

        $schedule = new Product();
        $schedule->n_classes = 1;
        $schedule->price = 130;
        $schedule->description = "1 clase";
        $schedule->expiration_days = 30;
        $schedule->save();

        $schedule = new Product();
        $schedule->n_classes = 5;
        $schedule->price = 628.36;
        $schedule->description = "5 clases";
        $schedule->expiration_days = 60;
        $schedule->save();

        $schedule = new Product();
        $schedule->n_classes = 10;
        $schedule->price = 1213.29;
        $schedule->description = "10 clases";
        $schedule->expiration_days = 120;
        $schedule->save();

        $schedule = new Product();
        $schedule->n_classes = 25;
        $schedule->price = 2708.23;
        $schedule->description = "25 clases";
        $schedule->expiration_days = 180;
        $schedule->save();

        $schedule = new Product();
        $schedule->n_classes = 50;
        $schedule->price = 4333.55;
        $schedule->description = "50 clases";
        $schedule->expiration_days = 365;
        $schedule->save();
    }
}
