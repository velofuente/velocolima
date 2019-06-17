<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\{Instructor, Schedule, Branch, Product, Tool, User, Purchase, Sale, UserSchedule};
use Illuminate\Support\Facades\Validator;
use DB, Log;
use PhpParser\Node\Stmt\Return_;

class AdminController extends Controller
{
    public function index()
    {
        // $instructors = Instructor::all();
        // $schedules = Schedule::all();
        // $products = Product::all();
        // $branches = Branch::all();
        // return view('/admin', compact ('instructors', 'schedules', 'products', 'branches'));
        return view('/admin');
    }
    public function showInstructors(){
        $instructors = Instructor::all();
        return view('/admin-instructors', compact ('instructors'));
    }

    public function showSchedules(){
        // $schedules = Schedule::all()->sortByDesc('day');
        $schedules = Schedule::all();
        $instructors = Instructor::all();
        $branches = Branch::all();
        return view('/admin-schedules', compact ('schedules','instructors','branches'));
    }

    public function showProducts(){
        $products = Product::all();
        return view('/admin-products', compact ('products'));
    }

    public function showBranches(){
        $branches = Branch::all();
        return view('/admin-branches', compact ('branches'));
    }

    public function showUsers(){
        $users = User::where('role_id', 2)->get();
        return view('/admin-users', compact ('users'));
    }

    public function showSales(){
        $products = Product::where('status',1)->get();
        // $users = User::where('role_id', 3)->get();
        $data = DB::table('users')->where('role_id', 3)->orderBy('id', 'asc')->paginate(5);
        return view('/admin-sales', compact ('products', 'data'));
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
                        ->where('name', 'like', '%'.$query.'%')
                        ->orWhere('last_name', 'like', '%'.$query.'%')
                        // ->orWhere('last_name', 'like', '%'.$query.'%')
                        ->orderBy($sort_by, $sort_type)
                        ->paginate(5);
            return view('pagination_data', compact('data'))->render();
        }
    }

    public function showReports(){
        $sales = Sale::with(['admin', 'purchase'])->whereRaw("date(created_at) = date(NOW())")->get();
        return view('/admin-reports', compact ('sales'));
    }

    public function showOperationsGrid(){
        date_default_timezone_set('America/Mexico_City');
        $id = [];
        $schedules = Schedule::where('day', now()->format('Y-m-d'))
            ->get()
            ->sortBy('hour');
        foreach ($schedules as $schedule) {
            array_push($id,$schedule->id);
        }
        $userSchedules = UserSchedule::whereIn('schedule_id', $id)->get();
        return view('/admin-operations', compact ('schedules', 'userSchedules'));
    }

    public function showClientsTable(Request $request){
        $id = [];
        $instances = UserSchedule::where('schedule_id', $request->schedule_id)->get();
        foreach($instances as $instance){
            array_push($id, $instance->user_id);
        }
        $clients = User::whereIn('id',$id)->get();
        return $clients;
    }

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
        $availability_x = Branch::select('reserv_lim_x')->where('id', $request->branch_id)->first();
        $availability_y = Branch::select('reserv_lim_y')->where('id', $request->branch_id)->first();
        $instructorBikes = Tool::where("branch_id", $request->branch_id)->where("type", "instructor")->get();
        $disabledBikes = Tool::where("branch_id", $request->branch_id)->where("type", "disabled")->get();
        $availability = $availability_x->reserv_lim_x * $availability_y->reserv_lim_y - ($disabledBikes->count() + $instructorBikes->count());
        DB::beginTransaction();
        Schedule::create([
            'day' => $request->day,
            'hour' => $request->hour,
            'instructor_id' => $request->instructor_id,
            'class_id' => 1,
            'room_id' => 1,
            'branch_id' => $request->branch_id,
            'reservation_limit' => $availability,
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
        $Schedule->branch_id = $request->branch_id;
        $Schedule->save();
        DB::commit();
        return response()->json([
            'status' => 'OK',
            'message' => "Horario editado con exito",
        ]);
    }
    public function deleteSchedule(Request $request){
        DB::beginTransaction();
        $Schedule = Schedule::find($request->schedule_id);
        $Schedule->delete();
        DB::commit();
        return response()->json([
            'status' => 'OK',
            'message' => "Horario eliminado con exito",
        ]);
    }
    public function addBranch(Request $request){
        DB::beginTransaction();
        $branch = Branch::create([
            'name' => $request->name,
            'address' => $request->address,
            'municipality' => $request->municipality,
            'state' => $request->state,
            'phone' => $request->phone,
            'reserv_lim_x' => $request->reserv_lim_x,
            'reserv_lim_y' => $request->reserv_lim_y,
        ]);
        DB::commit();
        $this->configGridBikes($request->disabledBikes, $request->instructorBikes, $branch);
        // DB::commit();
        return response()->json([
            'status' => 'OK',
            'message' => "Sucursal agregado con exito",
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
        $Branch->reserv_lim_x = $request->reserv_lim_x;
        $Branch->reserv_lim_y = $request->reserv_lim_y;
        $Branch->save();
        DB::commit();
        return response()->json([
            'status' => 'OK',
            'message' => "Sucursal editado con exito",
        ]);
    }
    public function deleteBranch(Request $request){
        DB::beginTransaction();
        $Branch = Branch::find($request->branch_id);
        $Branch->delete();
        DB::commit();
        return response()->json([
            'status' => 'OK',
            'message' => "Sucursal eliminado con exito",
        ]);
    }
    public function configGridBikes($disabledBikes, $instructorBikes, $branch){
        log::info($instructorBikes);
        log::info($disabledBikes);
        DB::beginTransaction();
        foreach ($instructorBikes as $bike) {
            Tool::create([
                'type' => 'instructor',
                'position' => $bike,
                'branch_id' => $branch->id,
            ]);
        }
        foreach ($disabledBikes as $bike) {
            Tool::create([
                'type' => 'disabled',
                'position' => $bike,
                'branch_id' => $branch->id,
            ]);
        }
        DB::commit();
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
        $Product = Product::find($request->product_id);
        $Product->n_classes = $request->n_classes;
        $Product->price = $request->price;
        $Product->description = $request->description;
        $Product->expiration_days = $request->expiration_days;
        $Product->type = $request->type;
        $Product->status = $request->status;
        $Product->save();
        DB::commit();
        return response()->json([
            'status' => 'OK',
            'message' => "Producto editado con exito",
        ]);
    }
    public function deleteProduct(Request $request){
        DB::beginTransaction();
        $Product = Product::find($request->product_id);
        $Product->delete();
        DB::commit();
        return response()->json([
            'status' => 'OK',
            'message' => "Producto eliminado con exito",
        ]);
    }
    public function addUser(Request $request){
        DB::beginTransaction();
        log::info($request->all());
        $user = $request->user();
        // $rules = [
        //     'name' => ['required', 'string', 'max:60'],
        //     'last_name' => ['required', 'string', 'max:60'],
        //     'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        //     'password' => ['required', 'string', 'min:6', 'confirmed'],
        //     'birth_date' => ['required', 'date'],
        //     'phone' => ['required', 'int', 'max:999999999999999'],
        //     'gender' => ['required', 'string', 'max:6', 'in:Hombre,Mujer'],
        // ];
        // log::info('entra después de $rules');
        // $messages = [
        //     "required" => "Este campo es requerido",
        //     "numeric" => "Este campo solo acepta numeros",
        //     "int" => "Este campo solo acepta numeros",
        //     "confirmed" => "Las contraseñas o coinciden",
        //     "unique" => "Este usuario ya existe",
        // ];
        // log::info('entra después de $messages');
        // $validator = Validator::make($request->all(), $rules, $messages);
        // if ($validator->fails()) {
        //     return back()
        //                 ->withErrors($validator)
        //                 ->withInput();
        // }
        log::info('Entra después de $validator');
        User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'birth_date' => $request->birth_date,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'role_id' => 2,
            'branch_id' => $user->branch_id,
        ]);
        DB::commit();
        log::info('entra después del DB::commit()');
        return response()->json([
            'status' => 'OK',
            'message' => "Usuario agregado con exito",
        ]);
    }
    public function editUser(Request $request){
        DB::beginTransaction();
        $User = User::find($request->user_id);
        // $User->name = $request->n_classes;
        $User->name = $request->name;
        $User->last_name = $request->last_name;
        $User->email = $request->email;
        $User->phone = $request->phone;
        $User->save();
        DB::commit();
        return response()->json([
            'status' => 'OK',
            'message' => "Usuario editado con exito",
        ]);
    }
    public function deleteUser(Request $request){
        DB::beginTransaction();
        $User = User::find($request->user_id);
        $User->delete();
        DB::commit();
        return response()->json([
            'status' => 'OK',
            'message' => "Usuario eliminado con exito",
        ]);
    }
    public function sale(Request $request){
        log::info($request);
        try {
            $admin = $request->user();
            $product = Product::where('id', "{$request->product_id}")->first();
            DB::beginTransaction();
            $purchase = Purchase::create([
                'product_id' => $product->id,
                'user_id' => $request->client_id,
                'n_classes' => $product->n_classes,
                'expiration_days' => $product->expiration_days,
            ]);
            Sale::create([
                'admin_id' => $admin->id,
                'purchase_id' => $purchase->id,
            ]);
            DB::commit();
            return response()->json([
                'status' => 'OK',
                'message' => "Venta realizada con exito",
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'Error',
                'message' => "Error: " . $e->getMessage(),
            ]);
        }
    }
}