<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = "Prueba";
        $user->last_name = "Prueba2";
        $user->gender = "Hombre";
        $user->email = "prueba@123.com";
        $user->password = bcrypt("prueba123");
        $user->birth_date = "1997/03/22";
        $user->phone = "3141234567";
        $user->weight = "123";
        $user->height = "123";
        $user->share_code = '123a45bc';
        $user->save();
    }
}
