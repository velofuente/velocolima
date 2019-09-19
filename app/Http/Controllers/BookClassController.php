<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\{UserSchedule, UserWaitList, User, Purchase, Tool, Schedule, Product};
use Illuminate\Support\Facades\Hash;
use SebastianBergmann\Environment\Console;

class BookClassController extends Controller
{
    public function book(Request $request)
    {
        //obtiene el usuario que hizo el request
        $requestUser = $request->user();
        //obtiene el cupo de la clase
        $availability = Schedule::select('reservation_limit')->where('id', $request->schedule_id)->first();
        //Obtiene la hora de la clase
        $ClasshourLimit = Schedule::select('hour')->where('id', $request->schedule_id)->first();
        //obtiene el numero de reservaciones que se han hecho a esa clase
        $instances = UserSchedule::where('schedule_id', $request->schedule_id)->where('status', "active")->count();
        //obtiene y revisa si el usuario ya tiene esta clase reservada
        $bookedClass = userSchedule::where('schedule_id', $request->schedule_id)->where('user_id', $requestUser->id)->first();
        //Validaa si el lugar está disponible
        $alreadyReserved = UserSchedule::where("bike", $request->bike)->where("schedule_id", $request->schedule_id)->first();
        //instructores de esa clase
        $instructorBikes = Tool::where("branch_id", $request->branch_id)->where("type", "instructor")->get();
        //bicicletas no disponibles de esa clase
        $disabledBikes = Tool::where("branch_id", $request->branch_id)->where("type", "disabled")->get();
        //obtiene la compra con la fecha de caducidad mas proxima del usuario con clases disponibles
        $compra = Purchase::where('user_id', $requestUser->id)
        ->where('n_classes', "<>", 0)
        //->whereRaw("created_at < DATE_ADD(created_at, INTERVAL expiration_days DAY)")
        //->whereRaw("NOW() < DATE_ADD(created_at, INTERVAL expiration_days DAY)")
        //->orderByRaw('DATE_ADD(created_at, INTERVAL expiration_days DAY)')->first();
        ->whereRaw("NOW() < DATE_ADD(created_at, INTERVAL expiration_days DAY)")
        ->orderByRaw('DATE_ADD(created_at, INTERVAL expiration_days DAY)')->first();
        if(!$compra){
            return response()->json([
                'status' => 'ERROR',
                'message' => "No tienes clases compradas. Compra clases para poder registrarte",
            ]);
        }
        //Obitene el numero total de clases del cliente
        $numClases = DB::table('purchases')->select(DB::raw('SUM(n_classes) as clases'))->where('user_id', '=', "{$requestUser->id}")->first();
        $classes = $numClases->clases;
        DB::beginTransaction();
        if(!$bookedClass){
            //obtiene el numero total de clases
            $numClases = DB::table('purchases')->select(DB::raw('SUM(n_classes) as clases'))->where('user_id', '=', "{$requestUser->id}")->first();
            $classes = $numClases->clases;
            //valida si el usuario tiene clases disponibles
            if($classes>0){
                //Valida si hay lugar disponible
                if($instances <= $availability->reservation_limit){
                    if(in_array($request->bike, (array)$disabledBikes)){
                        DB::commit();
                        return response()->json([
                            'status' => 'ERROR',
                            'message' => "Este lugar no se encuentra disponible.",
                            'updateClass' => 1
                        ]);
                    }
                    if(in_array($request->bike, (array)$instructorBikes)){
                        DB::commit();
                        return response()->json([
                            'status' => 'ERROR',
                            'message' => "Este lugar no se encuentra disponible.",
                            'updateClass' => 1
                        ]);
                    }
                    if($alreadyReserved && $alreadyReserved->status!='cancelled'){
                        DB::commit();
                        return response()->json([
                            'status' => 'ERROR',
                            'message' => "Ese lugar ya ha sido reservado.",
                            'updateClass' => 1
                        ]);
                    }
                    // TODO: Hour thing
                    if(Carbon::now()->format('H-i-s') > Carbon::parse($ClasshourLimit->hour)->subHours(2)->format('H-i-s')){
                        //obtiene el id de la bici,id del horario, id de la compra
                        UserSchedule::create([
                            'user_id' => $requestUser->id,
                            'schedule_id' => $request->schedule_id,
                            'purchase_id' => $compra->id,
                            //'tool_schedule_id' => $request->tool_schedule_id,
                            'bike' => $request->bike,
                            'status' => 'active',
                            'changedSit' => 0,
                        ]);
                        //Resta una clase a la compra del usuario y actualiza ese campo en la base de datos
                        $compra->n_classes -= 1;
                        $compra->save();
                        if($classes == 1){
                            $promocion = Product::where('description', 'Clase adicional')->first();
                            Purchase::create([
                                'product_id' => $promocion->id,
                                'user_id' => $requestUser->id,
                                'n_classes' => $promocion->n_classes,
                                'expiration_days' => $promocion->expiration_days,
                                'status' => 'pending',
                            ]);
                            app('App\Http\Controllers\MailSendingController')->addtionalFreeClass($requestUser->email,$requestUser->name);
                        }
                        DB::commit();
                        return response()->json([
                            'status' => 'OK',
                            'message' => "Lugar reservado con éxito.
                            Esta reservación no es cancelable, debido a que se está realizando antes de n horas del inicio de la clase.
                            Tips:
                                -Se puntual, llega al menos 10 min antes de la clase. Si llegaras tarde avisanos para guardar tu lugar 15 minutos
                                -Usa ropa comoda que transpire y calcetas deportivas",
                        ]);
                    }
                    //obtiene el id de la bici,id del horario, id de la compra
                    UserSchedule::create([
                        'user_id' => $requestUser->id,
                        'schedule_id' => $request->schedule_id,
                        'purchase_id' => $compra->id,
                        //'tool_schedule_id' => $request->tool_schedule_id,
                        'bike' => $request->bike,
                        'status' => 'active',
                        'changedSit' => 0,
                    ]);
                    //Resta una clase a la compra del usuario y actualiza ese campo en la base de datos
                    $compra->n_classes -= 1;
                    $compra->save();
                    if($classes == 1){
                        $promocion = Product::where('description', 'Clase adicional')->first();
                        Purchase::create([
                            'product_id' => $promocion->id,
                            'user_id' => $requestUser->id,
                            'n_classes' => $promocion->n_classes,
                            'expiration_days' => $promocion->expiration_days,
                            'status' => 'pending',
                        ]);
                        app('App\Http\Controllers\MailSendingController')->addtionalFreeClass($requestUser->email,$requestUser->name);
                    }
                    DB::commit();
                    return response()->json([
                        'status' => 'OK',
                        'message' => "Lugar reservado con éxito.
                        Esta reservación sólo puede modificarse o cancelarse hasta n horas antes de la clase
                        Tips:
                                -Se puntual, llega al menos 10 min antes de la clase. Si llegaras tarde avisanos para guardar tu lugar 15 minutos
                                -Usa ropa comoda que transpire y calcetas deportivas",
                    ]);
                } else{
                    return response()->json([
                        'status' => 'ERROR',
                        'message' => "No hay cupo disponible.",
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 'ERROR',
                    'message' => "No tienes clases compradas. Compra clases para poder registrarte",
                ]);
            }
        } else{
            if($bookedClass->changedSit == 0){
                if($alreadyReserved && $alreadyReserved->status!='cancelled'){
                    DB::commit();
                    return response()->json([
                        'status' => 'ERROR',
                        'message' => "Ese lugar ya ha sido reservado.",
                    ]);
                }
                if($bookedClass->status == 'cancelled'){
                    $bookedClass->status = 'active';
                    $bookedClass->bike = $request->bike;
                    $bookedClass->changedSit = 1;
                    $bookedClass->save();
                    //Resta una clase a la compra del usuario y actualiza ese campo en la base de datos
                    $compra->n_classes -= 1;
                    $compra->save();
                }else{
                    $bookedClass->bike = $request->bike;
                    $bookedClass->changedSit = 1;
                    $bookedClass->save();
                }
                DB::commit();
                return response()->json([
                    'status' => 'OK',
                    'message' => "Lugar cambiado con éxito",
                ]);
            } else{
                return response()->json([
                    'status' => 'ERROR',
                    'message' => "Solo puedes cambiar de lugar una vez",
                ]);
            }
        }
    }
    public function absentUserClass(Request $request){
        // TODO: Revisar la condición if($requestedClass=='active' || $requestedClass!='active') en esta función, cancelClass y attendClass
        $requestedClass = UserSchedule::find($request->schedule_id);
        if($requestedClass=='active' || $requestedClass!='active'){
            $requestedClass->status = 'absent';
            $requestedClass->changedSit = 0;
            $requestedClass->save();
            return response()->json([
                'status' => 'OK',
                'message' => 'El usuario no asistió a la clase',
            ]);
        }else{
            log::info($requestedClass);
            return response()->json([
                'status' => 'ERROR',
                'message' => 'Ocurrió un error al procesar la solicitud. Intenta refrescando la página.',
            ]);
        }
        log::info($requestedClass);
    }
    public function cancelClass(Request $request)
    {
        $requestedClass = UserSchedule::find($request->id);
        $ClasshourLimit = Schedule::select('hour')->where('id', $requestedClass->schedule_id)->first();
        $purchase = Purchase::find($requestedClass->purchase_id);
        if($requestedClass->status == 'cancelled'){
            return response()->json([
                'status' => 'OK',
                'message' => 'Clase cancelada con éxito',
            ]);
        }
        if($requestedClass->status=='active'||$requestedClass->status!='active'){
            if($ClasshourLimit != null){
                if(Carbon::now()->format('H-i-s') > Carbon::parse($ClasshourLimit->hour)->subHours(2)->format('H-i-s')){
                    $requestedClass->status = 'cancelled';
                    $requestedClass->changedSit = 0;
                    $requestedClass->save();
                    return response()->json([
                        'status' => 'OK',
                        'message' => "Clase cancelada con éxito, esta clase no es reembolsable",
                    ]);
                }
            }
            $requestedClass->status = 'cancelled';
            $requestedClass->changedSit = 0;
            $requestedClass->save();
            $purchase->n_classes ++;
            $purchase->save();
            return response()->json([
                'status' => 'OK',
                'message' => "Clase cancelada con éxito, se te reembolsará esta clase",
            ]);
        }else{
            return response()->json([
                'status' => 'ERROR',
                'message' => "La clase que quieres cancelar ya ha sido cancelada. Intenta refrescando la página.",
            ]);
        }
    }
    public function waitList(Request $request)
    {
        //obtiene el usuario que hizo el request
        $requestUser = $request->user();
        $waitList = DB::table('wait_lists')->select('id')->where('schedule_id', "{$request->schedule_id}")->first();
        UserWaitList::create([
            'user_id' => $requestUser->id,
            'wait_list_id' => $waitList,
            'status' => 'active',
        ]);
        return response()->json([
            'status' => 'OK',
            'message' => "Has sido agregado a la lista de espera de esta clase",
        ]);
    }
    public function attendClass(Request $request){
        $requestedClass = UserSchedule::find($request->reservation_id);
        if($requestedClass->status=='active'||$requestedClass->status!='active'){
            $requestedClass->status = 'taken';
            $requestedClass->save();
            return response()->json([
                'status' => 'OK',
                'message' => "Asistencia registrada con éxito",
            ]);
        }else{
            return response()->json([
                'status' => 'ERROR',
                'message' => "Ocurrió un error al procesar la solicitud. Intenta refrescando la página.",
            ]);
        }
    }

    public function claimClass(Request $request){
        //Validaa si el lugar está disponible
        $alreadyReserved = UserSchedule::where("bike", $request->bike)->where("schedule_id", $request->schedule_id)->first();
        //obtiene la compra con la fecha de caducidad mas proxima del usuario con clases disponibles
        $compra = Purchase::where('user_id', $request->user_id)
        ->where('n_classes', "<>", 0)
        ->whereRaw("created_at < DATE_ADD(created_at, INTERVAL expiration_days DAY)")
        ->orderByRaw('DATE_ADD(created_at, INTERVAL expiration_days DAY)')->first();
        //obtiene el numero total de clases
        $numClases = DB::table('purchases')->select(DB::raw('SUM(n_classes) as clases'))->where('user_id', '=', "{$request->user_id}")->first();
        $classes = $numClases->clases;
        //valida si el usuario tiene clases disponibles
        if($classes>0){
            if($alreadyReserved && $alreadyReserved->status!='cancelled'){
                DB::commit();
                return response()->json([
                    'status' => 'ERROR',
                    'message' => "Ese lugar ya ha sido reservado.",
                    'updateClass' => 1
                ]);
            }
            //obtiene el id de la bici,id del horario, id de la compra
            UserSchedule::create([
                'user_id' => $request->user_id,
                'schedule_id' => $request->schedule_id,
                'purchase_id' => $compra->id,
                //'tool_schedule_id' => $request->tool_schedule_id,
                'bike' => $request->bike,
                'status' => 'active',
                'changedSit' => 0,
            ]);
            //Resta una clase a la compra del usuario y actualiza ese campo en la base de datos
            $compra->n_classes -= 1;
            $compra->save();
            DB::commit();
            return response()->json([
                'status' => 'OK',
                'message' => "Lugar reservado con éxito",
            ]);
        } else {
            return response()->json([
                'status' => 'ERROR',
                'message' => "El usuario no tiene clases compradas.",
            ]);
        }
    }
    public function preRegister(Request $request){
        DB::beginTransaction();
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

        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make('temporal' . $password),
            'birth_date' => $request->birth_date,
            'phone' => $request->phone,
            'shoe_size' => $request->shoe_size,
            'gender' => $request->gender,
            'share_code' => $share_code,
            'role_id' => 3,
        ]);
        $purchase = Purchase::create([
            'product_id' => 2,
            'user_id' => $user->id,
            'n_classes' => 0,
            'expiration_days' => 1,
            // 'status' => 0,
        ]);
        UserSchedule::create([
            'user_id' => $user->id,
            'schedule_id' => $request->schedule_id,
            'purchase_id' => $purchase->id,
            'bike' => $request->bike,
            'status' => 'active',
            'changedSit' => 0,
        ]);
        DB::commit();
        app('App\Http\Controllers\MailSendingController')->walkInRegister($user->email,$user->name, $password);
        return response()->json([
            'status' => 'OK',
            'message' => "Usuario agregado con éxito",
        ]);
    }
}