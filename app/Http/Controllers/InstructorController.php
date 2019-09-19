<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Instructor,Branch,Schedule,Product, User,UserSchedule, Card, Tool};
use Response, Auth, Log;

class InstructorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $instructors = Instructor::all();
        return view('instructors', compact('instructors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Instructor $instructor)
    {
        return view('instructor-info', compact('instructor'));
    }

    // public function scheduleBackup()
    // {
    //     $instructors = Instructor::all();
    //     $branches = Branch::all();
    //     $products = Product::all();

    //     date_default_timezone_set('America/Mexico_City');
    //     $schedules = Schedule::whereBetween('day', [now()->modify('+5 days')->format('Y-m-d'), now()->modify('+12 days')])
    //                 ->get()
    //                 ->sortBy('hour');
    //     if(Auth::user()){
    //         $cards = Card::where('user_id', Auth::user()->id)->get();
    //         // dd($cards);
    //         // $cards = Card::all();
    //         return view('scheduleBackup', compact('instructors', 'branches', 'schedules','products','cards'));
    //     }else{
    //         return view('scheduleBackup', compact('instructors', 'branches', 'schedules','products'));
    //     }
    // }

    public function schedule()
    {
        $instructors = Instructor::all();
        $branches = Branch::all();
        $products = Product::all();

        date_default_timezone_set('America/Mexico_City');
        // $schedules = Schedule::whereBetween('day', [now()->format('Y-m-d'), now()->modify('+7 days')])
        //             ->get()
        //             ->sortBy('hour');

        // TODO: Probar bien velo.test/schedule, no debería haber error al tener una clase cuyo instructor fuese eliminado
        $schedules = Schedule::join('instructors', 'schedules.instructor_id', '=', 'instructors.id')
                            ->join('branches', 'schedules.branch_id', '=', 'branches.id')
                            ->select('schedules.id', 'schedules.day', 'schedules.hour', 'schedules.reservation_limit',
                            'schedules.instructor_id', 'schedules.class_id', 'schedules.room_id','schedules.branch_id', 'schedules.deleted_at',
                            'schedules.created_at', 'schedules.updated_at', 'schedules.description', 'instructors.id AS insId',
                            'instructors.name AS instructor_name', 'branches.id AS braId', 'branches.name AS branch_name')
                            ->whereNull('instructors.deleted_at')
                            ->whereNull('branches.deleted_at')
                            ->get()
                            ->sortBy('hour');
        // log::info($schedules);

        if(Auth::user()){
            $cards = Card::where('user_id', Auth::user()->id)->get();
            // dd($cards);
            // $cards = Card::all();
            return view('schedule', compact('instructors', 'branches', 'schedules','products','cards'));
        }else{
            return view('schedule', compact('instructors', 'branches', 'schedules','products'));
        }
    }

    public function bikeSelection(Request $request, Schedule $schedules)
    {
        if(!$request->user()){
            return redirect('login');
        }
        //obtiene el numero de reservaciones que se han hecho a esa clase
        $instances = UserSchedule::where('schedule_id', $schedules->id)->count();
        $instructors = Instructor::all();
        $instructor = Instructor::find($schedules->instructor_id)->first();
        $branches = Branch::all();
        $products = Product::all();
        $selectedBike = UserSchedule::where("user_id", $request->user()->id)->where("schedule_id", $schedules->id)->where("status","<>","cancelled")->first();
        $instructorBikes = Tool::select("position")->where("branch_id", $schedules->branch_id)->where("type", "instructor")->get()->pluck("position");
        $disabledBikes = array_map('strval', Tool::select("position")->where("branch_id", $schedules->branch_id)->where("type", "disabled")->get()->pluck("position")->toArray());
        if($selectedBike){
            $selectedBike = $selectedBike->bike;
        } else {
            $selectedBike = 0;
        }
        $reservedPlaces = array_map('strval', UserSchedule::where("user_id", "<>", $request->user()->id)->where("schedule_id", $schedules->id)->where("status","<>","cancelled")->get()->pluck("bike")->toArray());
        // dd($reservedPlaces);
        if($instances < ($schedules->branch->reserv_lim_x * $schedules->branch->reserv_lim_y))
            if(Auth::user()){
                $cards = Card::where('user_id', Auth::user()->id)->get();
                // dd($cards);
                // $cards = Card::all();
                return view('bike-selection', compact('instructors','instructor', 'branches', 'schedules', 'products', "selectedBike", "reservedPlaces", "instructorBikes", "disabledBikes","cards"));
            }else{
                return view('bike-selection', compact('instructors','instructor', 'branches', 'schedules', 'products', "selectedBike", "reservedPlaces", "instructorBikes", "disabledBikes"));
            }
        else
            return response()->json([
                'status' => 'ERROR',
                'message' => "No hay cupo disponible.",
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
