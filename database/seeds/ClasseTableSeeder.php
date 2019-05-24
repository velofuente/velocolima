<?php

use Illuminate\Database\Seeder;
use App\Classe;

class ClasseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $class = new Classe();
        $class->name = "Spinning";
        $class->save();
    }
}