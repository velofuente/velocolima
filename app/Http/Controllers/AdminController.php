<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Instructor, Schedule, Branch, Product, User};

class AdminController extends Controller
{
    public function addInstructor(Request $request){
        DB::beginTransaction();
        Instructor::create([
            'name' => $request->name, 
            'last_name' => $request->last_name, 
            'email' => $request->email, 
            'birth_date' => $request->birth_date, 
            'phone' => $request->phone, 
            'bio' => $request->bio,
        ]);
        DB::commit();
        return response()->json([
            'status' => 'OK',
            'message' => "Instructor agregado con éxito",
        ]); 
    }
    public function addSchedule(Request $request){
        DB::beginTransaction();
        Schedule::create([
            'day' => $request->day, 
            'hour' => $request->hour, 
            'instructor_id' => $request->instructor_id, 
            'reservation_limit' => $request->reservation_limit,
        ]);
        DB::commit();
        return response()->json([
            'status' => 'OK',
            'message' => "Horario agregado con éxito",
        ]); 
    }
    public function addBranch(Request $request){
        DB::beginTransaction();
        Branch::create([
            'name' => $request->name, 
            'address' => $request->address, 
            'municipality' => $request->municipality, 
            'state' => $request->state,
            'phone' => $request->phone,
        ]);
        DB::commit();
        return response()->json([
            'status' => 'OK',
            'message' => "Branch agregado con éxito",
        ]); 
    }
    public function addProduct(Request $request){
        DB::beginTransaction();
        Product::create([
            'n_classes' => $request->n_classes, 
            'price' => $request->price, 
            'description' => $request->description, 
            'expiration_days' => $request->expiration_days,
            'type' => $request->type,
            'status' => $request->status,
        ]);
        DB::commit();
        return response()->json([
            'status' => 'OK',
            'message' => "Producto agregado con éxito",
        ]); 
    }
    public function editProduct(Request $request){

    }
    // public function addUser(Request $request){

    // }
    public function configGridBikes(Request $request){

    }
}
