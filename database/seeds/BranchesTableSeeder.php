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
        $branch->name = "branch1";
        $branch->address = "address1";
        $branch->municipality = "colima";
        $branch->state = "colima";
        $branch->phone = "1234567890";
        $branch->save();
    }
}