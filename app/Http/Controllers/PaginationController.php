<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Product};
use DB;

class PaginationController extends Controller
{
    function index()
    {
        $data = DB::table('users')->orderBy('id', 'asc')->paginate(5);
        $products = Product::all();
        return view('admin-sales', compact('data','products'));
    }

    function fetch_data(Request $request)
    {
     if($request->ajax())
     {
      $sort_by = $request->get('sortby');
      $sort_type = $request->get('sorttype');
            $query = $request->get('query');
            $query = str_replace(" ", "%", $query);
      $data = DB::table('users')
                    ->where('id', 'like', '%'.$query.'%')
                    ->orWhere('name', 'like', '%'.$query.'%')
                    ->orWhere('last_name', 'like', '%'.$query.'%')
                    ->orderBy($sort_by, $sort_type)
                    ->paginate(5);
      return view('pagination_data', compact('data'))->render();
     }
    }
}
?>