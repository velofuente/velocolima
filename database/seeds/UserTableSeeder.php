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
        $user->name = "Admin";
        $user->last_name = "Admin";
        $user->gender = "Hombre";
        $user->email = "admin@velo.com";
        $user->password = bcrypt("prueba123");
        $user->birth_date = "1997/03/22";
        $user->phone = "3141234567";
        $user->role_id = 1;
        $user->save();
    }
}
