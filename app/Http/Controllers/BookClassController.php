<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\{UserSchedule, UserWaitList, User, Purchase};

class BookClassController extends Controller
{
    public function book(Request $request)
    {
        $availability = DB::table('schedules')->select('reservation_limit')->where('id', $request->schedule_id)->first();
        $instances = DB::table('user_schedules')->where('schedule_id', $request->schedule_id)->count();
        $requestUser = $request->user();
        //$requestUser = User::find(2);
        $bookedClass = userSchedule::where('schedule_id', $request->schedule_id)->where('user_id', $requestUser->id)->first();
        if(!$bookedClass){
            DB::beginTransaction();
            //Validar si hay lugar disponible
            if($instances < $availability->reservation_limit){
                //Validar si el lugar está disponible
                $alreadyReserved = UserSchedule::where("bike", $request->bike)->where("schedule_id", $request->schedule_id)->first();
                if($alreadyReserved){
                    DB::commit();
                    return response()->json([
                        'status' => 'ERROR',
                        'message' => "Ese lugar ya ha sido reservado.",
                        'updateClass' => 1
                    ]);
                }

                $compra = Purchase::where('user_id', $requestUser->id)->whereRaw("created_at < DATE_ADD(created_at, INTERVAL expiration_days DAY)")->first();
                //obtengo el id de la bici,id del horario, id de la compra
                UserSchedule::create([
                    'user_id' => $requestUser->id,
                    'schedule_id' => $request->schedule_id,
                    'purchase_id' => $compra->id,
                    //'tool_schedule_id' => $request->tool_schedule_id,
                    'bike' => $request->bike,
                    'status' => 'active',
                ]);
                $compra->n_classes -= 1;
                $compra->save();
                DB::commit();
                return response()->json([
                    'status' => 'OK',
                    'message' => "Lugar reservado con exito",
                ]);    
            }
            else{
                $waitList = DB::table('wait_lists')->select('id')->where('schedule_id', "{$request->schedule_id}")->first();
                UserWaitList::create([
                    'user_id' => $requestUser->id, 
                    'wait_list_id' => $waitList,
                ]);
                DB::commit();
                return response()->json([
                    'status' => 'OK',
                    'message' => "No hay cupo disponible. Has sido agregado a la lista de espera de esta clase",
                ]); 
            }
        } else {
            return response()->json([
                'status' => 'ERROR',
                'message' => "Ya tienes un lugar reservado en esta clase",
            ]);
        }
    }
}