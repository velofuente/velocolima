<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Instructor,Branch,Schedule,Product, UserSchedule, Card, Tool};
use Auth;

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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Instructor $instructor)
    {
        return view('instructor-info', compact('instructor'));
    }

    public function schedule()
    {
        $instructors = Instructor::all();
        $branches = Branch::all();
        $products = Product::all();

        date_default_timezone_set('America/Mexico_City');

        // TODO: Probar bien velo.test/schedule, no debería haber error al tener una clase cuyo instructor fuese eliminado
        $schedules = Schedule::join('instructors', 'schedules.instructor_id', '=', 'instructors.id')
            ->join('branches', 'schedules.branch_id', '=', 'branches.id')
            ->select('schedules.id', 'schedules.day', 'schedules.hour', 'schedules.reservation_limit',
            'schedules.instructor_id', 'schedules.class_id', 'schedules.room_id', 'schedules.branch_id', 'schedules.deleted_at',
            'schedules.created_at', 'schedules.updated_at', 'schedules.description', 'instructors.id AS insId',
            'instructors.name AS instructor_name', 'branches.id AS braId', 'branches.name AS branch_name')
            ->whereNull('instructors.deleted_at')
            ->whereNull('branches.deleted_at')
            ->get()
            ->sortBy('hour');

        if (Auth::user()) {
            $cards = Card::where('user_id', Auth::user()->id)->get();
            return view('schedule', compact('instructors', 'branches', 'schedules', 'products', 'cards'));
        } else {
            return view('schedule', compact('instructors', 'branches', 'schedules', 'products'));
        }
    }

    public function bikeSelection(Request $request, Schedule $schedules)
    {
        if (!$request->user()) {
            return redirect('/login');
        }
        //Carbon::parse($schedules->hour)->subHours($schedules->branch->cancelation_period)->format('H:i:s');
        $scheduleHourBeforeCancelation = $schedules->day.'T'.$schedules->hour;
        //obtiene el numero de reservaciones que se han hecho a esa clase
        $instances = UserSchedule::where('schedule_id', $schedules->id)->count();
        $instructors = Instructor::all();
        $instructor = Instructor::find($schedules->instructor_id);
        $branches = Branch::all();
        $products = Product::all();
        $selectedBike = UserSchedule::where("user_id", $request->user()->id)->where("schedule_id", $schedules->id)->where("status", "<>", "cancelled")->where("status", "<>", "absent")->first();
        $instructorBikes = Tool::select("position")->where("branch_id", $schedules->branch_id)->where("type", "instructor")->get()->pluck("position");
        $disabledBikes = array_map('strval', Tool::select("position")->where("branch_id", $schedules->branch_id)->where("type", "disabled")->get()->pluck("position")->toArray());
        if ($selectedBike) {
            $selectedBike = $selectedBike->bike;
        } else {
            $selectedBike = 0;
        }
        $reservedPlaces = array_map('strval', UserSchedule::where("user_id", "<>", $request->user()->id)->where("schedule_id", $schedules->id)->where("status", "<>", "cancelled")->where("status", "<>", "absent")->get()->pluck("bike")->toArray());
        if (env("RESERVED_PLACES")) {
            foreach (explode(", ", env("RESERVED_PLACES", [])) as $value) {
                array_push($reservedPlaces, (Integer) $value);
            }
        }
        if ($instances < ($schedules->branch->reserv_lim_x * $schedules->branch->reserv_lim_y)) {
            if (Auth::user()) {
                $cards = Card::where('user_id', Auth::user()->id)->get();
                return view('bike-selection', compact('instructors', 'instructor', 'branches', 'schedules', 'products', "selectedBike", "reservedPlaces", "instructorBikes", "disabledBikes", "cards", "scheduleHourBeforeCancelation"));
            } else {
                return view('bike-selection', compact('instructors', 'instructor', 'branches', 'schedules', 'products', "selectedBike", "reservedPlaces", "instructorBikes", "disabledBikes", "scheduleHourBeforeCancelation"));
            }
        }
        return response()->json([
            'status' => 'ERROR',
            'message' => "No hay cupo disponible.",
        ]);
    }
}
