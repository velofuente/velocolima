<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\{userSchedule,userWaitList};

class BookClassController extends Controller
{
    public function book(Request $request)
    {
        $availability = DB::table('schedules')->select('reservation_limit')->where('schedule_id', "{$request->schedule_id}")->first();
        $instances = DB::table('user_schedules')->where('schedule_id', "{$request->schedule_id}")->count();
        DB::beginTransaction();
        $requestUser = $request->user();
        if($availability < $instances){
            $compra = Purchase::select('user_id', "{$requestUser->id}")->where(DB::raw("created_at < DATE_ADD(created_at INTERVAL expiration_days DAY) finalDate"))->first();
            //obtengo el id de la bici,id del horario, id de la compra
            $classBooked = userSchedule::create([
                'user_id' => $requestUser->user_id,
                'schedule_id' => $request->schedule_id,
                'purchase_id' => $compra->id,
                //'tool_schedule_id' => $request->tool_schedule_id,
                'bike' => $request->bike,
                'status' => true
            ]);
        }
        else{
            $waitList = DB::table('wait_lists')->select('id')->where('schedule_id', "{$request->schedule_id}")->first();
            $addToList = userWaitList::create([
                'user_id' => $requestUser->user_id, 
                'wait_list_id' => $waitList,
            ]);
        }
    }
}
