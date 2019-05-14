<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\{userSchedule,userWaitList,User, Purchase};

class BookClassController extends Controller
{
    public function book(Request $request)
    {
        $availability = DB::table('schedules')->select('reservation_limit')->where('id', $request->schedule_id)->first();
        $instances = DB::table('user_schedules')->where('schedule_id', $request->schedule_id)->count();
        DB::beginTransaction();
        $requestUser = $request->user();
        //$requestUser = User::find(2);
        $bookedClass = userSchedule::where('schedule_id', $request->schedule_id)->where('user_id', $requestUser->id)->first();
        if(!$bookedClass){
            if($instances < $availability->reservation_limit){
                $compra = Purchase::where('user_id', $requestUser->id)->whereRaw("created_at < DATE_ADD(created_at, INTERVAL expiration_days DAY)")->first();
                //obtengo el id de la bici,id del horario, id de la compra
                userSchedule::create([
                    'user_id' => $requestUser->id,
                    'schedule_id' => $request->schedule_id,
                    'purchase_id' => $compra->id,
                    //'tool_schedule_id' => $request->tool_schedule_id,
                    'bike' => $request->bike,
                    'status' => 'active',
                ]);
            }
            else{
                $waitList = DB::table('wait_lists')->select('id')->where('schedule_id', "{$request->schedule_id}")->first();
                userWaitList::create([
                    'user_id' => $requestUser->id,
                    'wait_list_id' => $waitList,
                ]);
            }
            DB::commit();
        }
        else{
            return "Ya estás registrado en esta clase";
        }
    }
}