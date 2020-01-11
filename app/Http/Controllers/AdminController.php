<?php

namespace App\Http\Controllers;

use DB, Log;
use Carbon\Carbon;
use App\ProductSchedule;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\{Instructor, Schedule, Branch, Product, Tool, User, Purchase, Sale, UserSchedule};

// use App\Traits\UploadTrait;

class AdminController extends Controller
{
    use GeneralTrait;
    // use UploadTrait;

    public function index()
    {
        // $instructors = Instructor::all();
        // $schedules = Schedule::all();
        // $products = Product::all();
        // $branches = Branch::all();
        // return view('/admin', compact ('instructors', 'schedules', 'products', 'branches'));
        // return view('/admin');
        return view('/admin/app');
    }
    public function showInstructors(){
        $instructors = Instructor::all();
        // return view('/admin-instructors', compact ('instructors'));
        return view('/admin/instructors', compact ('instructors'));
    }

    public function showSchedules(){
        // $schedules = Schedule::all()->sortByDesc('day');
        // $schedules = Schedule::all();
        $schedules = Schedule::orderBy('day')->orderBy('hour')->get();
        $instructors = Instructor::all();
        $branches = Branch::all();
        // return view('/admin-schedules', compact ('schedules','instructors','branches'));
        return view('/admin/schedules', compact ('schedules','instructors','branches'));
    }

    public function getNextClasses(){
        //$schedules = Schedule::with(['instructor', 'branch'])->select("*", DB::RAW("CONCAT(day, ' ', hour) fullDate"))->whereNull('deleted_at')->orderBy('fullDate')->get();
        $schedules = Schedule::join('instructors', 'schedules.instructor_id', '=', 'instructors.id')
                            ->join('branches', 'schedules.branch_id', '=', 'branches.id')
                            ->select('schedules.id AS id', 'schedules.reservation_limit AS reservation_limit', 'schedules.day AS day', 'schedules.hour AS hour', 'schedules.description AS description', 'instructors.id AS instructor_id', 'instructors.name AS instructor_name', 'branches.id AS branch_id', 'branches.name AS branch_name', DB::RAW("CONCAT(schedules.day, ' ', schedules.hour) AS fullDate"))
                            ->whereNull('schedules.deleted_at')
                            ->whereNull('instructors.deleted_at')
                            ->whereNull('branches.deleted_at')
                            ->orderBy('fullDate')
                            ->get();
        $reservedPlaces = [];
        $nextSchedules = [];
        foreach ($schedules as $schedule){
            if (Carbon::parse($schedule->fullDate)->gte( now()->format('Y-m-d H:i:s')) ){
                $availableBikes = [];
                $branch = Branch::find($schedule->branch_id);
                $temp = $branch->reserv_lim_x * $branch->reserv_lim_y;
                $unavailableBikes = array_map('strval', Tool::select("position")->where("branch_id", $schedule->branch_id)->get()->pluck("position")->toArray());
                $reservedPlaces = array_map('strval', UserSchedule::where("schedule_id", $schedule->id)->where("status","<>","cancelled")->get()->pluck("bike")->toArray());
                for ($i=1; $i < $temp; $i++) {
                    if(!in_array($i, $unavailableBikes) &&  !in_array($i, $reservedPlaces))
                        // if(!in_array($i, $reservedPlaces))
                        array_push($availableBikes, $i);
                }

                $formatDay = date('d M o', strtotime($schedule->day));
                $formatHour = date('g:i A', strtotime($schedule->hour));
                $nextSchedules[] = [
                    'formatDay' => $formatDay,
                    'formatHour' => $formatHour,
                    // 'object' => json_encode($schedule),
                    'object' => $schedule,
                    'availableBikes' => count($availableBikes),
                    'reservedBikes' => count($reservedPlaces),
                ];
            }
        }
        return $nextSchedules;
    }

    public function getPreviousClasses(){
        $schedules = Schedule::with(['instructorWithTrashed', 'branchWithTrashed'])->select("*", DB::RAW("CONCAT(day, ' ', hour) fullDate"))->orderBy('fullDate', 'desc')->get();
        $previousSchedules = [];
        foreach ($schedules as $schedule){
            if (Carbon::parse($schedule->fullDate)->lt( now()->format('Y-m-d H:i:s')) ){

                $availableBikes = [];
                $branch = Branch::withTrashed()->find($schedule->branch_id);
                $temp = $branch->reserv_lim_x * $branch->reserv_lim_y;
                $unavailableBikes = array_map('strval', Tool::select('position')->where('branch_id', $schedule->branch_id)->get()->pluck('position')->toArray());
                $reservedPlaces = array_map('strval',UserSchedule::where("schedule_id", $schedule->id)->where('status','<>','cancelled')->get()->pluck('bike')->toArray());
                for($i=1; $i < $temp; $i++){
                    if(!in_array($i, $unavailableBikes) && !in_array($i, $reservedPlaces))
                        // if(!in_array($i, $reservedPlaces))
                        array_push($availableBikes, $i);
                }

                $formatDay = date('d M o', strtotime($schedule->day));
                $formatHour = date('g:i A', strtotime($schedule->hour));
                $previousSchedules[] = [
                    'formatDay' => $formatDay,
                    'formatHour' => $formatHour,
                    'object' => $schedule,
                    'availableBikes' => count($availableBikes),
                    'reservedBikes' => count($reservedPlaces),
                ];
            }
        }
        return $previousSchedules;
    }

    public function showProducts(){
        $products = Product::with('productSchedule')->get();
        return view('/admin/products', compact ('products'));
    }

    public function showBranches(){
        $branches = Branch::all();
        // return view('/admin-branches', compact ('branches'));
        return view('/admin/branches', compact ('branches'));
    }

    public function showUsers(){
        $users = User::where('role_id', 1)->get();
        // return view('/admin-users', compact ('users'));
        return view('/admin/users', compact ('users'));
    }

    public function showClients(){
        //$numClases = User::join('purchases','purchases.user_id','=','users.id')->select(DB::raw('SUM(n_classes) as clases'))->get();
        // $numClases = User::select(DB::raw())->where('role_id', 3)->get();
        //$temp = [];
        $products = Product::where('status',1)->get();
        $clients = User::where('role_id',3)->orderBy('id')->get();//paginate(5);
        foreach ($clients as $client){
            $numClases = Purchase::select(DB::raw('SUM(n_classes) as clases'))->where('user_id', '=', "{$client->id}")->first();
            $bookedClasses = UserSchedule::with("schedule.instructor", "schedule.room", "schedule")->where('user_id', "{$client->id}")->where('status', 'active')->count();
            $client->availableClasses = $numClases;
            $client->bookedClasses = $bookedClasses;
            //array_push($temp,$numClases->clases);
        }
        log::info($clients);
        // return  $temp;
        // return view('/admin-clients', compact ('clients'));
        return view('/admin/clients', compact ('clients','products'));
    }

    public function showSales(){
        $products = Product::where('status',1)->get();
        // $users = User::where('role_id', 3)->get();
        $data = DB::table('users')->where('role_id', 3)->orderBy('id', 'asc')->paginate(10);
        log::info($data);
        foreach ($data as $client){
            $numClases = Purchase::select(DB::raw('SUM(n_classes) as clases'))->where('user_id', '=', "{$client->id}")->whereRaw("NOW() < DATE_ADD(created_at, INTERVAL expiration_days DAY)")->first();
            $bookedClasses = UserSchedule::with("schedule.instructor", "schedule.room", "schedule")->where('user_id', "{$client->id}")->where('status', 'active')->count();
            $client->availableClasses = $numClases;
            $client->bookedClasses = $bookedClasses;
            //array_push($temp,$numClases->clases);
        }
        return view('/admin/sales', compact ('products', 'data'));
    }

    function fetch_data(Request $request)
    {
        if($request->ajax())
        {
            $sort_by = $request->get('sortby');
            $sort_type = $request->get('sorttype');
            $queryN = $request->get('query');
            $queryN = explode(" ", $queryN);
            $data = DB::table('users')
                    ->where(function($query) use ($queryN) {
                            //verificar si viene por correo
                            $query->where(function($query) use ($queryN){
                                $query->where('name', 'like', '%'.$queryN[0].'%')->orWhere('email', 'like', '%'.$queryN[0].'%');
                            });
                            /*
                            if(false === strpos($queryN[0], "@")){
                                $query->where('name', 'like', '%'.$queryN[0].'%');
                            }else{
                                $query->orWhere('email', 'like', '%'.$queryN[0].'%');
                            }*/
                            if(count($queryN) >= 2){
                                if(count($queryN) == 3){
                                    $query->where(function($query) use ($queryN) {
                                        $query->where('last_name', 'like', '%'.$queryN[1].' '.$queryN[2].'%');
                                    });
                                }else{
                                    $query->where(function($query) use ($queryN) {
                                        $query->where('last_name', 'like', '%'.$queryN[1].'%');
                                    });
                                }
                            }
                        })
                       /* ->where('name', 'like', '%'.$query.'%')
                        ->orWhere('last_name', 'like', '%'.$query.'%')*/
                        // ->orWhere('last_name', 'like', '%'.$query.'%')
                        ->orderBy('last_name', 'asc')
                        ->paginate(10);
            foreach ($data as $client){
                $numClases = Purchase::select(DB::raw('SUM(n_classes) as clases'))->where('user_id', '=', "{$client->id}")->whereRaw("NOW() < DATE_ADD(created_at, INTERVAL expiration_days DAY)")->first();
                $bookedClasses = UserSchedule::with("schedule.instructor", "schedule.room", "schedule")->where('user_id', "{$client->id}")->where('status', 'active')->count();
                $client->availableClasses = $numClases;
                $client->bookedClasses = $bookedClasses;
                //array_push($temp,$numClases->clases);
            }
            return view('pagination_data', compact('data'))->render();
        }
    }

    function fetch_users(Request $request)
    {
        if($request->ajax())
        {
            $sort_by = $request->get('sortby');
            $sort_type = $request->get('sorttype');
                $query = $request->get('query');
                $query = str_replace(" ", "%", $query);
            $data = DB::table('user_schedules')
                        ->where('name', 'like', '%'.$query.'%')
                        ->orWhere('last_name', 'like', '%'.$query.'%')
                        // ->orWhere('last_name', 'like', '%'.$query.'%')
                        ->orderBy($sort_by, $sort_type)
                        ->paginate(10);
            return view('pagination_data', compact('data'))->render();
        }
    }

    public function showReports()
    {
        //obtener lista de productos gratis
        $products = Product::select('id')->where('type', 'Free')->pluck('id');
        // $sales = Sale::with(['admin', 'purchase'])->whereRaw("date(created_at) = date(NOW())")->get();
        $sales = Purchase::with(['productWithTrashed','client', 'sales.admin'])->where('created_at','like', '%'.date('Y-m-d').'%')
        ->whereNotIn('product_id',$products)->get();

        // return view('/admin-reports', compact ('sales'));
        return view('/admin/reports', compact ('sales'));
    }

    public function showOperationsGrid($selected_schedule = null){
        // return 1;
        $users = User::all();
        date_default_timezone_set('America/Mexico_City');
        $id = [];
        // $schedules = Schedule::where('day', now()->format('Y-m-d'))
        //     ->get()
        //     ->sortBy('hour');
        // $schedules = Schedule::whereBetween('day', [now()->format('Y-m-d'), now()->modify('+7 days')])
        //     ->get()
        //     ->sortBy('hour')
        //     ->sortBy('day');
        $schedules = Schedule::join('instructors', 'schedules.instructor_id', '=', 'instructors.id')
                            ->join('branches','schedules.branch_id','=','branches.id')
                            ->select('schedules.id','schedules.day','schedules.hour','schedules.reservation_limit','schedules.instructor_id','schedules.class_id',
                            'schedules.room_id','schedules.branch_id','schedules.deleted_at','schedules.created_at','schedules.updated_at','schedules.description',
                            'instructors.id AS insId', 'instructors.name AS insName', DB::raw('CONCAT(schedules.day, " ", schedules.hour) AS limit_day'))
                            ->whereNull('instructors.deleted_at')
                            ->whereNull('schedules.deleted_at')
                            ->whereNull('branches.deleted_at')
                            ->whereBetween('schedules.day', [now()->format('Y-m-d'), now()->modify('+7 days')])
                            ->orderBy('schedules.day')
                            ->orderBy('schedules.hour')
                            ->get();
                            // ->sortBy('schedules.hour')
                            // ->sortBy('schedules.day');
        foreach ($schedules as $schedule) {
            array_push($id,$schedule->id);
        }
        $selected_schedule = isset($selected_schedule) ? $selected_schedule : null;
        $userSchedules = UserSchedule::whereIn('schedule_id', $id)->where('status','<>','cancelled')->get();
        // return view('/admin-operations', compact ('schedules', 'userSchedules', 'users'));

        if(isset($selected_schedule)){
            if(in_array($selected_schedule, $id) == true){
                // return view("/admin/operations", compact ('schedules', 'userSchedules', 'users', 'selected_schedule'));
                return view("admin/operations", compact('schedules', 'userSchedules', 'users', 'selected_schedule'));
            } else {
                return redirect('/admin/operations');
            }
        } else {
            return view('/admin/operations', compact ('schedules', 'userSchedules', 'users'));
        }
    }

    public function showClientsTable(Request $request){
        $id = [];
        $instances = UserSchedule::where('schedule_id', $request->schedule_id)->where('status','<>','cancelled')->get();
        foreach($instances as $instance){
            array_push($id, $instance->user_id);
        }
        // $clients = User::whereIn('id',$id)->get();
        // $clients = UserSchedule::with('user')->where('schedule_id', $request->schedule_id)->whereIn('user_id', $id)->get();
        $clients = UserSchedule::join('users','user_schedules.user_id','users.id')->
                                join('purchases','user_schedules.purchase_id','purchases.id')->
                                join('products','purchases.product_id','products.id')->
                                join('schedules','schedules.id','user_schedules.schedule_id')->
                                selectRaw('schedules.day as daySchedule, user_schedules.id AS id, user_schedules.status AS status, user_schedules.bike AS bike, users.name AS name, users.last_name AS last_name, users.birth_date AS birth_date, users.email AS email, users.shoe_size AS shoe_size, users.phone AS phone, products.type AS type')->
                                where('user_schedules.schedule_id', $request->schedule_id)->
                                where('user_schedules.status','<>','cancelled')->
                                whereIn('user_schedules.user_id', $id)->get();
        log::info($clients);
        return $clients;
    }

    public function getOperationBikes(Request $request){
        $availableBikes = [];
        $schedule = Schedule::find($request->schedule_id);
        log::info($schedule);
        $branch = Branch::find($schedule->branch_id);
        $temp = $branch->reserv_lim_x * $branch->reserv_lim_y;
        $unavailableBikes = array_map('strval', Tool::select("position")->where("branch_id", $schedule->branch_id)->get()->pluck("position")->toArray());
        $reservedPlaces = array_map('strval', UserSchedule::where("schedule_id", $schedule->id)->where("status","<>","cancelled")->get()->pluck("bike")->toArray());
        for ($i=1; $i < $temp; $i++) {
            if(!in_array($i, $unavailableBikes))
                if(!in_array($i, $reservedPlaces))
                    array_push($availableBikes, $i);
        }
        return $availableBikes;
    }

    function scheduledReservedPlaces(Request $request){
        $availableBikes = [];
        $schedule = Schedule::find($request->schedule_id);
        $branch = Branch::find($schedule->branch_id);
        $temp = $branch->reserv_lim_x * $branch->reserv_lim_y;
        $unavailableBikes = array_map('strval', Tool::select("position")->where("branch_id", $schedule->branch_id)->get()->pluck("position")->toArray());
        $reservedPlaces = array_map('strval', UserSchedule::where("schedule_id", $schedule->id)->where("status","<>","cancelled")->get()->pluck("bike")->toArray());
        for ($i=1; $i < $temp; $i++) {
            if(!in_array($i, $unavailableBikes))
                if(!in_array($i, $reservedPlaces))
                    array_push($availableBikes, $i);
        }
        if ( count($availableBikes) < 14 ){
            return ([
                $message = "La clase tiene reservaciones activas",
                "status" => 'Error',
                "message" => $message,
            ]);
        } else {
            return([
                $message = "Clase libre para eliminar",
                "status" => 'OK',
                "message" => $message,
            ]);
        }
    }

    public function getNonScheduledUsers(Request $request){
        $nonScheduledUsers = [];
        $users = User::orderBy("id")->get();
        $temp = $users->count();
        $schedule = Schedule::find($request->schedule_id);
        log::info('getNon: '.$schedule);
        $instances = array_map('strval', UserSchedule::select("user_id")->where('schedule_id', $schedule->id)->orderBy("id")->get()->pluck("user_id")->toArray());
        log::info($users);
        log::info($instances);
        log::info($temp);
        foreach ($users as $user) {
            if(!in_array($user->id, $instances)){
                $nonScheduledUsers[] = $user;
            }
        }
        /*for ($i=0; $i < $temp; $i++) {
            if(!in_array($users[$i], $instances))
                $nonScheduledUsers[] = $users[$i];
        }*/
        log::info($nonScheduledUsers);
        return $nonScheduledUsers;
    }

    public function getUserInfo(Request $request){
        log::info("entro al getUserInfo");
        $userInfo = [];
        // nombre del cliente, clases disponibles, historial de compras, si el historial es largo debe de tener scrolling y como se compró (mostrador o web)
        $booking = UserSchedule::where("id",$request->userSchedule_id)->where('status','<>','cancelled')->first();
        $name = $booking->user->name . " " . $booking->user->last_name;
        $numClases = DB::table('purchases')->select(DB::raw('SUM(n_classes) as clases'))->where('user_id', '=', "{$booking->user->id}")->whereRaw("NOW() < DATE_ADD(created_at, INTERVAL expiration_days DAY)")->first();
        $availableClasses = $numClases->clases;
        $lastClases = DB::table('purchases')->select(DB::raw('SUM(n_classes) as clases'))->where('user_id', '=', "{$booking->user->id}")->whereRaw("NOW() >= DATE_ADD(created_at, INTERVAL expiration_days DAY)")->first();
        $expiredClasses = ($lastClases->clases) ? $lastClases->clases : 0;
        $purchaseHistory = Purchase::join('products','purchases.product_id','=',"products.id")
                            ->selectRaw('purchases.created_at AS saleDate,products.description AS product,products.n_classes AS purchasedClasses,DATE_ADD(purchases.created_at, INTERVAL purchases.expiration_days DAY) AS expiration,products.price AS price,purchases.card_id AS saleType')
                            ->where('user_id', '=', "{$booking->user->id}")
                            ->orderBy('purchases.created_at')
                            ->get()
                            ->toArray();
        log::info($purchaseHistory);
        array_push($userInfo, $name, $availableClasses, $expiredClasses,$purchaseHistory);
        return $userInfo;
    }

    public function getUserInfoReports(Request $request){
        //prueba
        log::info("entro al getUserInfoReports");
        $userInfo = [];
        // nombre del cliente, clases disponibles, historial de compras, si el historial es largo debe de tener scrolling y como se compró (mostrador o web)
        $user = User::find($request->user_id);
        log::info($user);
        $name = $user->name . " " . $user->last_name;
        log::info($name);
        $numClases = DB::table('purchases')->select(DB::raw('SUM(n_classes) as clases'))->where('user_id', '=', "{$user->id}")->whereRaw("NOW() < DATE_ADD(created_at, INTERVAL expiration_days DAY)")->first();
        $availableClasses = $numClases->clases;
        $lastClases = DB::table('purchases')->select(DB::raw('SUM(n_classes) as clases'))->where('user_id', '=', "{$user->id}")->whereRaw("NOW() >= DATE_ADD(created_at, INTERVAL expiration_days DAY)")->first();
        $expiredClasses = ($lastClases->clases) ? $lastClases->clases : 0;
        $purchaseHistory = Purchase::join('products','purchases.product_id','=',"products.id")
                            ->selectRaw('purchases.created_at AS saleDate,products.description AS product,products.n_classes AS purchasedClasses,DATE_ADD(purchases.created_at, INTERVAL purchases.expiration_days DAY) AS expiration,products.price AS price,purchases.card_id AS saleType')
                            ->where('user_id', '=', "{$user->id}")
                            ->orderBy('purchases.created_at')
                            ->get()
                            ->toArray();
        log::info($purchaseHistory);
        array_push($userInfo, $name, $availableClasses, $expiredClasses, $purchaseHistory);
        return $userInfo;
    }

    public function getReports(Request $request){
        //obtener lista de productos gratis
        $products = Product::select('id')->where('type', 'Free')->pluck('id');
        if($request->fromDate == $request->toDate){
            /*$sales = Sale::join('purchases','sales.purchase_id','=','purchases.id')->
            join('products','purchases.product_id','=','products.id')->
            join('users','purchases.user_id','=','users.id')->
            selectRaw('purchases.card_id AS saleType, sales.id AS id, sales.created_at AS date, users.id AS user_id, users.name AS name,users.last_name AS last_name, users.email AS email, products.description AS product, products.price AS price, (SELECT name from users where id=sales.admin_id) AS admin')->
            where('sales.created_at', 'like','%'.$request->fromDate.'%')->get();*/

            $sales = Purchase::with(['productWithTrashed','client', 'sales.admin'])->where('created_at','like', '%'.$request->fromDate.'%')
            ->whereNotIn('product_id',$products)->get();
        }else{
            /*$sales = Sale::join('purchases','sales.purchase_id','=','purchases.id')->
            join('products','purchases.product_id','=','products.id')->
            join('users','purchases.user_id','=','users.id')->
            selectRaw('purchases.card_id AS saleType, sales.id AS id, sales.created_at AS date, users.id AS user_id, users.name AS name,users.last_name AS last_name, users.email AS email, products.description AS product, products.price AS price, (SELECT name from users where id=sales.admin_id) AS admin')->
            whereBetween('sales.created_at', [$request->fromDate, $request->toDate])->get();*/

           $sales = Purchase::with(['productWithTrashed','client', 'sales.admin'])->whereBetween('created_at', [$request->fromDate, $request->toDate])
            ->whereNotIn('product_id',$products)->get();
        };
        
        // $sales = Sale::with(['admin', 'purchase'])->whereRaw("date(created_at) = date(NOW())")->get();
        /*$sales = Purchase::with(['productWithTrashed','client', 'sales.admin'])->where('created_at','like', '%'.date('Y-m-d').'%')
        ->whereNotIn('product_id',$products)->get();*/

        // switch ($request->range) {
        //     case 'hoy':
        //         log::info("hoy");
        //         //$sales = Sale::with(['admin', 'purchase'])->whereDate('created_at','=', date('Y-m-d'))->get();
        //         $sales = Sale::join('purchases','sales.purchase_id','=','purchases.id')->
        //                     join('products','purchases.product_id','=','products.id')->
        //                     join('users','purchases.user_id','=','users.id')->
        //                     selectRaw('sales.id AS id, sales.created_at AS date, users.id AS user_id, users.name AS name,users.last_name AS last_name, users.email AS email, products.description AS product, products.price AS price, (SELECT name from users where id=sales.admin_id) AS admin')->
        //                     whereDate('sales.created_at','=', date('Y-m-d'))->get();
        //         log::info($sales);
        //         return $sales;
        //         break;
        //     case 'semana':
        //         log::info("semana");
        //         //$sales = Sale::with(['admin', 'purchase'])->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
        //         $sales = Sale::join('purchases','sales.purchase_id','=','purchases.id')->
        //                     join('products','purchases.product_id','=','products.id')->
        //                     join('users','purchases.user_id','=','users.id')->
        //                     selectRaw('sales.id AS id, sales.created_at AS date, users.id AS user_id, users.name AS name,users.last_name AS last_name, users.email AS email, products.description AS product, products.price AS price, (SELECT name from users where id=sales.admin_id) AS admin')->
        //                     whereBetween('sales.created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
        //         log::info($sales);
        //         return $sales;
        //         break;
        //     case 'mes':
        //         log::info("mes");
        //         //$sales = Sale::with(['admin', 'purchase'])->whereMonth('created_at', '=', date('m'))->get();
        //         $sales = Sale::join('purchases','sales.purchase_id','=','purchases.id')->
        //                     join('products','purchases.product_id','=','products.id')->
        //                     join('users','purchases.user_id','=','users.id')->
        //                     selectRaw('sales.id AS id, sales.created_at AS date, users.id AS user_id, users.name AS name,users.last_name AS last_name, users.email AS email, products.description AS product, products.price AS price, (SELECT name from users where id=sales.admin_id) AS admin')->
        //                     whereMonth('sales.created_at', '=', date('m'))->get();
        //         log::info($sales);
        //         return $sales;
        //         break;
        //     default:
        //         log::info("default");
        //         break;
        // }
        return $sales;
    }

    public function addInstructor(Request $request){
        DB::beginTransaction();
        $instructor  = Instructor::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'birth_date' => $request->birth_date,
            'phone' => $request->phone,
            'bio' => $request->bio,
        ]);
        log::info($instructor);
        //actulizando la foto de perfil del instructor
        if($request->profileImageAdd){
            $images = $request->profileImageAdd;
            $imagePath = Storage::disk('public')->put('/coaches/'.$instructor->id, $images);
            $instructor->profile_image = '/storage/'.$imagePath;
        }
        if ($request->fullBodyPhotoAdd) {
            $imagesB = $request->fullBodyPhotoAdd;
            $imagePath = Storage::disk('public')->put('/coaches/'.$instructor->id, $imagesB);
            $instructor->full_body_image = '/storage/'.$imagePath;
        }
        $instructor->save();
        // $pathHead = $request->head->storeAs('public/img/instructors', '{$request->name}-Head.png');
        // $pathBody = $request->body->storeAs('public/img/instructors', '{$request->name}-Body.png');
        // log::info($pathHead, $pathBody);
        DB::commit();
        return response()->json([
            'status' => 'OK',
            'message' => "Instructor agregado con éxito",
        ]);
    }
    public function editInstructor(Request $request){
        DB::beginTransaction();
        log::info($request->all());
        $Instructor = Instructor::find($request->instructor_id);
        $Instructor->name = $request->name;
        $Instructor->last_name = $request->last_name;
        $Instructor->email = $request->email;
        $Instructor->birth_date = $request->birth_date;
        $Instructor->phone = $request->phone;
        $Instructor->bio = $request->bio;
        //actulizando la foto de perfil del instructor
        if($request->profileImage){
            $images = $request->profileImage;
            $imagePath = Storage::disk('public')->put('/coaches/'.$Instructor->id, $images);
            $Instructor->profile_image = '/storage/'.$imagePath;
        }
        if ($request->fullBodyPhoto) {
            $imagesB = $request->fullBodyPhoto;
            $imagePath = Storage::disk('public')->put('/coaches/'.$Instructor->id, $imagesB);
            $Instructor->full_body_image = '/storage/'.$imagePath;
        }
        //Guardando la información 
        $Instructor->save();
        DB::commit();
        return response()->json([
            'status' => 'OK',
            'message' => "Instructor editado con éxito",
        ]);
    }
    public function deleteInstructor(Request $request){
        $activeClasses = Instructor::join('schedules', 'instructors.id', '=', 'schedules.instructor_id')
                        ->join('branches', 'schedules.branch_id', '=', 'branches.id')
                        // ->select('*',DB::RAW("CONCAT(schedules.day, ' ', schedules.hour) AS fullDate"))
                        ->select('instructors.id AS instructor', 'schedules.deleted_at AS schedules.deleted_at', 'branches.deleted_at AS branches.deleted_at', DB::RAW("CONCAT(schedules.day, ' ', schedules.hour) AS fullDate"))
                        ->where('instructors.id', '=', $request->instructor_id)
                        ->whereNull('schedules.deleted_at')
                        ->whereNull('branches.deleted_at')
                        ->get();
        foreach ($activeClasses as $key) {
            if (Carbon::parse($key->fullDate)->gte(now()->format('Y-m-d H:i:s')))
            {
                return response()->json([
                    'status' => 'Error',
                    'message' => 'El instructor tiene reservaciones activas',
                ]);
            }
        }
        DB::beginTransaction();
        $Instructor = Instructor::find($request->instructor_id);
        $Instructor->delete();
        DB::commit();
        return response()->json([
            'status' => 'OK',
            'message' => "Instructor eliminado con éxito",
        ]);
    }

    public function getInstructorSchedule(Request $request){
        $activeClasses = Instructor::join('schedules', 'instructors.id', '=', 'schedules.instructor_id')
                                   ->join('branches', 'schedules.branch_id', '=', 'branches.id')
                                //    ->select('*', DB::RAW("CONCAT(schedules.day, ' ', schedules.hour) AS fullDate"))
                                   ->select('instructors.id AS instructor', 'schedules.deleted_at AS schedules.deleted_at', 'branches.deleted_at AS branches.deleted_at', DB::RAW("CONCAT(schedules.day, ' ', schedules.hour) AS fullDate"))
                                   ->where('instructors.id', '=', $request->instructor_id)
                                   ->whereNull('schedules.deleted_at')
                                   ->whereNull('branches.deleted_at')
                                   ->get();
        foreach($activeClasses as $key){
            if(Carbon::parse($key->fullDate)->gte(now()->format('Y-m-d H:i:s'))){
                return response()->json([
                    'status' => 'Error',
                    'message' => 'El instructor tiene reservaciones activas.',
                ]);
            }
        }
        return response()->json([
            'status' => 'OK',
            'message' => 'El instructor no tiene reservaciones activas'
        ]);
    }

    public function repeatedSchedule(Request $request){
        $schedule = Schedule::select('*')->where('day', $request->day)->where('hour', $request->hour)->first();
        return response()->json([
            'status' => 'Error',
            'message' => 'Ya existe un horario con esa fecha y hora',
        ]);
    }

    public function addSchedule(Request $request){
        // $rules = [
        //     'branch_id' => 'required',
        //     'day' => 'required',
        //     'day' => 'date_format:Y-m-d H:i:s|before:today',
        //     'hour' => 'required',
        //     'instructor_id' => 'required'
        // ];
        // $messages = [
        //     'branch_id.required' => "La sucursal ingresada no es válida.",
        //     'day.required' => "El día ingresado no es válido.",
        //     'hour.required' => "La hora ingresada no es válida.",
        //     'instructor_id.required' => "El instructor ingresado no es válido."
        // ];
        // $validator = Validator::make($request->all(), $rules, $messages);
        // if($validator->fails()){
        //     $code = 1006;
        //     return $this->responseError(1006,$validator->errors());
        // }

        $availability_x = Branch::select('reserv_lim_x')->where('id', $request->branch_id)->first();
        $availability_y = Branch::select('reserv_lim_y')->where('id', $request->branch_id)->first();
        $instructorBikes = Tool::where("branch_id", $request->branch_id)->where("type", "instructor")->get();
        $disabledBikes = Tool::where("branch_id", $request->branch_id)->where("type", "disabled")->get();
        $availability = $availability_x->reserv_lim_x * $availability_y->reserv_lim_y - ($disabledBikes->count() + $instructorBikes->count());

        $fullRequestDate = $request->day .' '. $request->hour;
        if (Carbon::parse($fullRequestDate)->lte( now()->format('Y-m-d H:i:s')) ){
            return response()->json([
                'status' => 'Error',
                'message' => 'La fecha ingresada no es válida',
            ]);
        }
        $schedule = Schedule::select('*')->where('day', $request->day)->where('hour', $request->hour)->first();
        if($schedule){
            return response()->json([
                'status' => 'Error',
                'message' => 'Ya existe un horario con esa fecha y hora',
            ]);
        } else {
            DB::beginTransaction();
            Schedule::create([
                'day' => $request->day,
                'hour' => $request->hour,
                'instructor_id' => $request->instructor_id,
                'description' => $request->description,
                'class_id' => 1,
                'room_id' => 1,
                'branch_id' => $request->branch_id,
                'reservation_limit' => $availability,
            ]);
            DB::commit();
            return response()->json([
                'status' => 'OK',
                'message' => "Horario agregado con éxito",
            ]);
        }
    }
    public function editSchedule(Request $request){
        if(strlen($request->description) > 27){
            log::info(strlen($request->description));
            return response()->json([
                'status' => 'Error',
                'message' => 'La longitud de la descripción debe ser menor a 27 caracteres.'
            ]);
        }
        $schedule = Schedule::select('*')->where('day', $request->day)->where('hour', $request->hour)->where('id', '!=', $request->schedule_id)->first();
        if($schedule){
            return response()->json([
                'status' => 'Error',
                'message' => 'Ya existe un horario con esa fecha y hora',
            ]);
        } else {
            DB::beginTransaction();
            $Schedule = Schedule::find($request->schedule_id);
            $Schedule->day = $request->day;
            $Schedule->hour = $request->hour;
            $Schedule->instructor_id = $request->instructor_id;
            $Schedule->description = $request->description;
            $Schedule->branch_id = $request->branch_id;
            $Schedule->save();
            DB::commit();
            return response()->json([
                'status' => 'OK',
                'message' => "Horario editado con éxito",
            ]);
        }
    }
    public function deleteSchedule(Request $request){
        DB::beginTransaction();
        $Schedule = Schedule::find($request->schedule_id);
        $Schedule->delete();
        DB::commit();
        return response()->json([
            'status' => 'OK',
            'message' => "Horario eliminado con éxito",
        ]);
    }
    public function addBranch(Request $request){
        log::info($request->instructorBikes);
        if (!isset($request->instructorBikes)) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Debe asignarse un lugar para el instructor.',
            ]);
        }
        DB::beginTransaction();
        $branch = Branch::create([
            'name' => $request->name,
            'address' => $request->address,
            'municipality' => $request->municipality,
            'state' => $request->state,
            'phone' => $request->phone,
            'reserv_lim_x' => $request->reserv_lim_x,
            'reserv_lim_y' => $request->reserv_lim_y,
            'cancelation_period' => $request->cancelation_period,
        ]);
        DB::commit();
        $this->configGridBikes($request->disabledBikes, $request->instructorBikes, $branch);
        // DB::commit();
        return response()->json([
            'status' => 'OK',
            'message' => "Sucursal agregado con éxito",
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
        $Branch->cancelation_period = $request->cancelation_period;
        $Branch->save();
        DB::commit();
        return response()->json([
            'status' => 'OK',
            'message' => "Sucursal editado con éxito",
        ]);
    }
    public function deleteBranch(Request $request){
        DB::beginTransaction();
        $Branch = Branch::find($request->branch_id);
        $Branch->delete();
        DB::commit();
        return response()->json([
            'status' => 'OK',
            'message' => "Sucursal eliminado con éxito",
        ]);
    }
    public function configGridBikes($disabledBikes, $instructorBikes, $branch){
        if (count($instructorBikes) ==0) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Debe asignarse un lugar para el instructor.',
            ]);
        }else{
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
    }
    public function addProduct(Request $request){
        if( strlen($request->description) > 20 ){
            return response()->json([
                'status' => 'Error',
                'message' => 'La descripción no debe ser mayor a 20 caracteres.',
            ]);
        }
        DB::beginTransaction();
        $product = Product::create([
            'n_classes' => $request->n_classes,
            'price' => $request->price,
            'description' => $request->description,
            'expiration_days' => $request->expiration_days,
            'type' => $request->type,
            'status' => $request->status,
        ]);
        if ($request->available_days) {
            ProductSchedule::create([
                'product_id' => $product->id,
                'available_days' => implode(',', $request->available_days),
                'schedules' => "{$request->begin_at}-{$request->end_at}",
            ]);
        }
        DB::commit();
        return response()->json([
            'status' => 'OK',
            'message' => "Producto agregado con éxito",
        ]);
    }

    public function editProduct(Request $request){
        if( strlen($request->description) > 20 ){
            return response()->json([
                'status' => 'Error',
                'message' => 'La descripción no debe ser mayor a 20 caracteres.',
            ]);
        }

        $endAt = $request->end_at;
        $beginAt = $request->begin_at;
        $availableDays = $request->available_days;

        DB::beginTransaction();
        $Product = Product::find($request->product_id);
        $Product->n_classes = $request->n_classes;
        $Product->price = $request->price;
        $Product->description = $request->description;
        $Product->expiration_days = $request->expiration_days;
        $Product->type = $request->type;
        $Product->status = $request->status;
        $Product->save();

        $productSchedule = ProductSchedule::withTrashed()->where('product_id', $Product->id)->first();
        if ($productSchedule && $availableDays && $productSchedule->deleted_at) {
            $productSchedule->available_days = implode(',', $availableDays);
            $productSchedule->schedules = "{$beginAt}-{$endAt}";
            $productSchedule->save();
            $productSchedule->restore();
        } elseif ($productSchedule && !$availableDays) {
            $productSchedule->delete();
        } elseif($productSchedule && $availableDays) {
            $productSchedule->available_days = implode(',', $availableDays);
            $productSchedule->schedules = "{$beginAt}-{$endAt}";
            $productSchedule->save();
        } elseif ($availableDays) {
            ProductSchedule::create([
                'product_id' => $Product->id,
                'available_days' => implode(',', $availableDays),
                'schedules' => "{$beginAt}-{$endAt}",
            ]);
        }

        DB::commit();
        return response()->json([
            'status' => 'OK',
            'message' => "Producto editado con éxito",
        ]);
    }

    public function deleteProduct(Request $request){
        DB::beginTransaction();
        $Product = Product::find($request->product_id);
        $productSchedule = ProductSchedule::where('product_id', $Product->id)->delete();
        $Product->delete();
        DB::commit();
        return response()->json([
            'status' => 'OK',
            'message' => "Producto eliminado con éxito",
        ]);
    }

    public function addUser(Request $request){
        log::info("========== addUser ==========");
        log::info($request->all());

        $password = substr($request->phone, -4);
        DB::beginTransaction();
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
        $newUser = User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            // 'password' => Hash::make($password),
            'password' => Hash::make('temporal'.$password),
            'birth_date' => $request->birth_date,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'role_id' => 1,
            'branch_id' => $user->branch_id,
        ]);
        DB::commit();
        app('App\Http\Controllers\MailSendingController')->walkInRegister($newUser->email,$newUser->name, $password);
        return response()->json([
            'status' => 'OK',
            'message' => "Usuario agregado con éxito",
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
        $User->birth_date = $request->birth_date;
        $User->gender = $request->gender;
        $User->save();
        DB::commit();
        return response()->json([
            'status' => 'OK',
            'message' => "Usuario editado con éxito",
        ]);
    }
    public function deleteUser(Request $request){
        DB::beginTransaction();
        $User = User::find($request->user_id);
        $User->delete();
        DB::commit();
        return response()->json([
            'status' => 'OK',
            'message' => "Usuario eliminado con éxito",
        ]);
    }
    public function sale(Request $request){
        log::info($request);
        try {
            $admin = $request->user();
            $product = Product::where('id', "{$request->product_id}")->first();
            DB::beginTransaction();
            //promocion clase adicional
            /*$promotion = Purchase::where('user_id', $request->client_id)->where('status', 'pending')->latest()->first();
            log::info($promotion);
            if($promotion != null){
                if(Carbon::now() < Carbon::parse($promotion->created_at)->addDay() && $product->n_classes >= 10){
                    $promotion->status = 'active';
                    $promotion->save;
                }
            }*/
            //verificar si compro un paquete de mas o igual a 10 clases
            if(intval($product->n_classes) >= 10){
                //promocion clase adicional verificar si tiene 1 clase
                $lastClassPurchase = Purchase::where('user_id', $request->client_id)
                ->where('n_classes', "<>", 0)
                ->whereRaw("NOW() < DATE_ADD(created_at, INTERVAL expiration_days DAY)")
                ->orderByRaw('DATE_ADD(created_at, INTERVAL expiration_days DAY)')->first();
                if($lastClassPurchase){
                    // Verificar que la última clase adquirida no haya sido la clase gratis de registro o la gratis de cumpleaños
                    if($lastClassPurchase->product->id != 1 ||  $lastClassPurchase->product->id != 12){
                        // En Pruebas la clase cumpleaños es id = 11, y la de regalo es id = 12
                        $promocion = Product::find(13);
                        Purchase::create([
                            'product_id' => $promocion->id,
                            'user_id' => $request->client_id,
                            'n_classes' => $promocion->n_classes,
                            'expiration_days' => $promocion->expiration_days,
                            'status' => 'active',
                        ]);
                    }
                }
            }
            $purchase = Purchase::create([
                'product_id' => $product->id,
                'user_id' => $request->client_id,
                'n_classes' => $product->n_classes,
                'expiration_days' => $product->expiration_days,
                // 'status' => 0,
            ]);
            Sale::create([
                'admin_id' => $admin->id,
                'purchase_id' => $purchase->id,
            ]);
            DB::commit();
            return response()->json([
                'status' => 'OK',
                'message' => "Venta realizada con éxito",
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'Error',
                'message' => "Error: " . $e->getMessage(),
            ]);
        }
    }
    public function addClient(Request $request)
    {
        //Definir mensajes personalizados
        $messages = [
            'name.required' => "Debes especificar al menos un nombre",
            'last_name.required' => "Debes especificar al menos un apellido",
            'email.required' => "Debes ingresar un email",
            'email.max' => "El tamaño máximo para un correo es 240 caracteres",
            'email.email' => "El correo ingresado no es válido",
            'email.unique' => "El correo ingresado ya está registrado",
            'birth_date.required' => "Debes ingresar una fecha de cumpleaños",
            'phone.required' => "Debes ingresar un teléfono",
            'phone.min' => "La longitud del teléfono debe ser mayor a 9 dígitos",
            'phone.max' => "La longitud del teléfono debe ser menor a 15 dígitos",
            'gender.required' => "Debes seleccionar un género",
            'shoe_size.required' => "Debes seleccionar una talla de calzado",
        ];
        //Definir reglas de validación
        $rules = [
            'name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|max:245|unique:users',
            'birth_date' => 'required',
            'phone' => 'required|min:10|max:10|unique:users',
            'gender' => 'required|in:Hombre,Mujer',
            'shoe_size' => 'required',
        ];
        //Validar datos de entrada
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->getMessageBag()->first()
            ]);
        }
        //Generar contraseña temporal
        $password = substr($request->phone, -4);
        // Available alpha caracters
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        // generate a pin based on 2 * 7 digits + a random character
        $pin = $characters[rand(0, strlen($characters) - 1)]
        . $characters[rand(0, strlen($characters) - 1)]
        . $characters[rand(0, strlen($characters) - 1)]
        . $characters[rand(0, strlen($characters) - 1)];
        // shuffle the result
        $share_code = str_shuffle($pin);
        DB::beginTransaction();
        //Guardar el usuario
        $user = new User([
            'name' => $request->get('name'),
            'last_name' => $request->get('last_name'),
            'email' => $request->get('email'),
            'password' => Hash::make('temporal'.$password), //Generar Contraseña usando temporal y los últimos 4 dígitos del teléfono
            'birth_date' => $request->get('birth_date'),
            'phone' => $request->get('phone'),
            'gender' => $request->get('gender'),
            'shoe_size' => $request->get('shoe_size'),
            'share_code' => $share_code,
            'customer_id' => null,
            'role_id' => 3,
        ]);
        $user->save();
        DB::commit();
        app('App\Http\Controllers\MailSendingController')->walkInRegister($user->email,$user->name, $password);
        return response()->json([
            'status' => 'OK',
            'message' => "Cliente registrado con éxito",
        ]);
    }
}