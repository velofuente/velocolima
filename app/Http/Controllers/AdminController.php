<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Instructor, Schedule, Branch, Product};
use DB;

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
            'message' => "Instructor agregado con exito",
        ]); 
    }
    public function editInstructor(Request $request){
        DB::beginTransaction();
        $Instructor = Instructor::find($request->instructor_id);
        $Instructor->name = $request->name;
        $Instructor->last_name = $request->last_name;
        $Instructor->email = $request->email;
        $Instructor->birth_date = $request->birth_date; 
        $Instructor->phone = $request->phone;
        $Instructor->bio = $request->bio;
        $Instructor->save();
        DB::commit();
        return response()->json([
            'status' => 'OK',
            'message' => "Instructor editado con exito",
        ]); 
    }
    public function deleteInstructor(Request $request){
        DB::beginTransaction();
        $Instructor = Instructor::find($request->instructor_id);
        $Instructor->delete();
        DB::commit();
        return response()->json([
            'status' => 'OK',
            'message' => "Instructor eliminado con exito",
        ]); 
    }
    public function addSchedule(Request $request){
        DB::beginTransaction();
        Schedule::create([
            'day' => $request->day, 
            'hour' => $request->hour, 
            'instructor_id' => $request->instructor_id,
            'class_id' => 1,
            'reservation_limit' => $request->reservation_limit,
            'room_id' => 1,
        ]);
        DB::commit();
        return response()->json([
            'status' => 'OK',
            'message' => "Horario agregado con exito",
        ]); 
    }
    public function editSchedule(Request $request){
        DB::beginTransaction();
        $Schedule = Schedule::find($request->schedule_id);
        $Schedule->day = $request->day;
        $Schedule->hour = $request->hour;
        $Schedule->instructor_id = $request->instructor_id;
        $Schedule->reservation_limit = $request->reservation_limit; 
        $Schedule->save();
        DB::commit();
        return response()->json([
            'status' => 'OK',
            'message' => "Schedule editado con exito",
        ]); 
    }
    public function deleteSchedule(Request $request){
        DB::beginTransaction();
        $Schedule = Schedule::find($request->schedule_id);
        $Schedule->delete();
        DB::commit();
        return response()->json([
            'status' => 'OK',
            'message' => "Schedule eliminado con exito",
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
            'message' => "Branch agregado con exito",
        ]); 
    }
    public function editBranch(Request $request){
        DB::beginTransaction();
        $Branch = Branch::find($request->branch_id);
        $Branch->name = $request->name;
        $Branch->address = $request->address;
        $Branch->municipality = $request->municipality;
        $Branch->state = $request->state; 
        $Branch->phone = $request->phone; 
        $Branch->save();
        DB::commit();
        return response()->json([
            'status' => 'OK',
            'message' => "Branch editado con exito",
        ]); 
    }
    public function deleteBranch(Request $request){
        DB::beginTransaction();
        $Branch = Branch::find($request->branch_id);
        $Branch->delete();
        DB::commit();
        return response()->json([
            'status' => 'OK',
            'message' => "Branch eliminado con exito",
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
            'message' => "Producto agregado con exito",
        ]); 
    }
    public function editProduct(Request $request){
        DB::beginTransaction();
        $Product = Product::find($request->branch_id);
        $Product->n_classes = $request->n_classes;
        $Product->price = $request->price;
        $Product->description = $request->description; 
        $Product->expiration_days = $request->expiration_days;
        $Product->type = $request->type;
        $Product->municipality = $request->status;
        $Product->save();
        DB::commit();
        return response()->json([
            'status' => 'OK',
            'message' => "Product editado con exito",
        ]); 
    }
    public function deleteProduct(Request $request){
        DB::beginTransaction();
        $Product = Product::find($request->product_id);
        $Product->delete();
        DB::commit();
        return response()->json([
            'status' => 'OK',
            'message' => "Product eliminado con exito",
        ]); 
    }
    public function configGridBikes(Request $request){

    }
}
