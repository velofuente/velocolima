<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class DatatableController extends Controller
{
    public function user(){
        $users = User::where('role_id', 3)->get();

        return datatables()->of($users)->toJson();
    }
}
