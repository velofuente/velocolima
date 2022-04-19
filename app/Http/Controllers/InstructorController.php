<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Instructor,Branch,Schedule,Product, UserSchedule,
    Branches, Card, Tool};
use App\Models\{Place, Brand};
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

    public function schedule($branchId = null)
    {
        $places = Place::all();
        $brands = Brand::all();
        $instructors = Instructor::all();
        $branches = Branch::all();
        $products = Product::all();

        date_default_timezone_set('America/Mexico_City');

        // TODO: Probar bien velo.test/schedule, no debería haber error al tener una clase cuyo instructor fuese eliminado
        $schedules = [];
        $products = [];

        if (Auth::user()) {
            $cards = Card::where('user_id', Auth::user()->id)->get();
            return view('schedule', compact('instructors', 'places', 'products', 'cards', 'branchId'));
        } else {
            return view('schedule', compact('instructors', 'products', 'places', 'branchId'));
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
        $instances = UserSchedule::where('schedule_id', $schedules->id)->where('status','active')->count();
        $instructors = Instructor::all();
        $instructor = Instructor::find($schedules->instructor_id);
        $branches = Branch::all();
        $currentBranch = $schedules->branch;
        $products = $currentBranch->products;
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
        $brand = $schedules->branch->brands->first();
        $hasSelectedPlace = $brand->id == 1 ? true : false;
        if ($instances < ($schedules->branch->reserv_lim_x * $schedules->branch->reserv_lim_y)) {
            if (Auth::user()) {
                $cards = Card::where('user_id', Auth::user()->id)->get();
                return view('bike-selection', compact('instructors', 'instructor', 'branches', 'schedules', 'products', "selectedBike", "reservedPlaces", "instructorBikes", "disabledBikes", "cards", "scheduleHourBeforeCancelation", 'hasSelectedPlace'));
            } else {
                return view('bike-selection', compact('instructors', 'instructor', 'branches', 'schedules', 'products', "selectedBike", "reservedPlaces", "instructorBikes", "disabledBikes", "scheduleHourBeforeCancelation", 'hasSelectedPlace'));
            }
        }
        return response()->json([
            'status' => 'ERROR',
            'message' => "No hay cupo disponible.",
        ]);
    }
}
