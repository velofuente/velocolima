<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\{UserSchedule, UserWaitList, User, Purchase, Tool, Schedule};
use SebastianBergmann\Environment\Console;

class BookClassController extends Controller
{
    public function book(Request $request)
    {
        //obtiene el usuario que hizo el request
        $requestUser = $request->user();
        //Obtiene el cupo de la clase
        $availability_x = Schedule::select('reserv_lim_x')->where('id', $request->schedule_id)->first();
        $availability_y = Schedule::select('reserv_lim_y')->where('id', $request->schedule_id)->first();
        //bici del instructor
        $instructorBikes = Tool::where("schedule_id", $request->schedule_id)->where("type", "instructor")->get();
        //bicis dsabilitadas
        $disabledBikes = Tool::where("schedule_id", $request->schedule_id)->where("type", "disabled")->get();
        $availability = $availability_x->reserv_lim_x * $availability_y->reserv_lim_y - ($disabledBikes->count() + $instructorBikes->count());
        //obtiene el numero de reservaciones que se han hecho a esa clase
        $instances = DB::table('user_schedules')->where('schedule_id', $request->schedule_id)->count();
        //obtiene y revisa si el usuario ya tiene esta clase reservada
        $bookedClass = userSchedule::where('schedule_id', $request->schedule_id)->where('user_id', $requestUser->id)->first();
        //Validaa si el lugar está disponible
        $alreadyReserved = UserSchedule::where("bike", $request->bike)->where("schedule_id", $request->schedule_id)->first();
        //obtiene la compra con la fecha de caducidad mas proxima del usuario con clases disponibles
        $compra = Purchase::where('user_id', $requestUser->id)
        ->where('n_classes', "<>", 0)
        ->whereRaw("created_at < DATE_ADD(created_at, INTERVAL expiration_days DAY)")
        //->whereRaw("NOW() < DATE_ADD(created_at, INTERVAL expiration_days DAY)")
        ->orderByRaw('DATE_ADD(created_at, INTERVAL expiration_days DAY)')->first();
        DB::beginTransaction();
        if(!$bookedClass){
            //obtiene el numero total de clases
            $numClases = DB::table('purchases')->select(DB::raw('SUM(n_classes) as clases'))->where('user_id', '=', "{$requestUser->id}")->first();
            $classes = $numClases->clases;
            //valida si el usuario tiene clases disponibles
            if($classes>0){
                //Valida si hay lugar disponible
                if($instances < $availability){
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
                    DB::commit();
                    return response()->json([
                        'status' => 'OK',
                        'message' => "Lugar reservado con éxito",
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
                }
                $bookedClass->bike = $request->bike;
                $bookedClass->changedSit = 1;
                $bookedClass->save();
                //Resta una clase a la compra del usuario y actualiza ese campo en la base de datos
                $compra->n_classes -= 1;
                $compra->save();
                DB::commit();
                return response()->json([
                    'status' => 'Ok',
                    'message' => "Lugar cambiado con exito",
                ]);
            } else{
                return response()->json([
                    'status' => 'ERROR',
                    'message' => "Solo puedes cambiar de lugar una vez",
                ]);
            }
        }
    }
    public function cancelClass(Request $request)
    {
        $requestedClass = UserSchedule::find($request->id);
        $purchase = Purchase::find($requestedClass->purchase_id);
        if($requestedClass->status!='cancelled'){
            $requestedClass->status = 'cancelled';
            $requestedClass->save();
            $purchase->n_classes += 1;
            $purchase->save();
            return response()->json([
                'status' => 'OK',
                'message' => "Clase cancelada con exito",
            ]);
        }else{
            return response()->json([
                'status' => 'ERROR',
                'message' => "La clase que quieres cancelar ya ha sido cancelada. Intenta refrescando la pagina.",
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
}