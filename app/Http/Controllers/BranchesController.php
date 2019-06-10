<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Branch;

class BranchesController extends Controller
{
    public function index()
    {
        //obtiene todas las sucursales
        $branches = Branch::all();
        return view('branches',compact('branches'));
    }
}
