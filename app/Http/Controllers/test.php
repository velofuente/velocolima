<?php

namespace App\Http\Controllers;
use App\User;

use Illuminate\Http\Request;

class test extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function test()
    {
        return User::find(1);
    }
}
