<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            InstructorTableSeeder::class,
            RoleTableSeeder::class,
            UserTableSeeder::class,
            BranchesTableSeeder::class,
            RoomsTableSeeder::class,
            ClasseTableSeeder::class,
            ScheduleTableSeeder::class,
            ProductsTableSeeder::class,
        ]);
    }
}