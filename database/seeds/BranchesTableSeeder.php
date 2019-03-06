<?php

use Illuminate\Database\Seeder;
use App\Branch;

class BranchesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $branch = new Branch();
        $branch->name = "Providencia";
        $branch->address = "Avenida Providencia 2388, Col. Providencia, 44630";
        $branch->municipality = "Guadalajara";
        $branch->state = "Jalisco";
        $branch->phone = "3311995890";
        $branch->save();

        $branch = new Branch();
        $branch->name = "Zentralia";
        $branch->address = "Paseo Miguel de la Madrid Hurtado 301, Valle Dorado, 28018";
        $branch->municipality = "Colima";
        $branch->state = "Colima";
        $branch->phone = "3141234567";
        $branch->save();
    }
}