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
        $branch->name = "Ignacio Sandoval";
        $branch->address = "Ignacio Sandoval 1948 Interior A4, La Cantera, 28018";
        $branch->municipality = "Colima";
        $branch->state = "Colima";
        $branch->phone = "1234567890";
        $branch->save();
    }
}