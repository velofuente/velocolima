<?php

namespace App\Http\Controllers;

use App\{User, Purchase, UserSchedule, UserWaitList, Card};
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Auth, JWTAuth, DB, Validator, Session;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $requestUser = $request->user();
        if ($requestUser->role_id == 1) {
            return redirect("/admin");
        }
        $purchaseHistory = Purchase::with(['product'])->select("*", DB::raw("DATE_ADD(created_at, INTERVAL expiration_days DAY) finalDate"))->where('user_id', '=', "{$requestUser->id}")->get()->sortByDesc('created_at');
        $cards = Card::where('user_id', '=', "{$requestUser->id}")->get();
        $numClases = Purchase::select(DB::raw('SUM(n_classes) as clases'))->whereRaw("NOW() <= DATE_ADD(created_at, INTERVAL expiration_days DAY)")->where('user_id', '=', "{$requestUser->id}")->groupBy("id")->get();
        $classes = $numClases->sum("clases");
        $bookedClasses = UserSchedule::with("schedule.instructor", "schedule.room", "schedule")->where('user_id', "{$requestUser->id}")->where('status', 'active')->get();
        $previousClasses = UserSchedule::with('scheduleWithTrashed.instructorWithTrashed')->where('user_id', "{$requestUser->id}")->whereNotIn("status", ["active"])->whereRaw("created_at < NOW()")->get();
        // TODO: ARREGLAR: Se rompe cuando hay un Active en un horario que ya pasó en PreviousClasses
        // $temporal debe hacer (aún no funciona bien) que los user_schedules con status = 'Active' y con dateTime < now() se vuelvan "Absent" de manera automática, para evitar que queden como "Active"
        // $temporal = UserSchedule::with('scheduleWithTrashed.instructorWithTrashed')->where('user_id', "{$requestUser->id}")->whereNotIn("status", ["active"])->whereRaw("created_at < NOW()")->get();
        // log::info($temporal);
        // foreach($temporal as $key){
        //     log::info('Antes: '.$key);
        //     $fullDate = $key->scheduleWithTrashed->day. ' '. $key->scheduleWithTrashed->hour;
        //     if(Carbon::parse($fullDate)->gte(now()->format('Y-m-d H:i:s'))){
        //         log::info($key);
        //         $key->status = 'absent';
        //         $key->save();
        //     }
        // }
        // log::info($temporal);
        $UserWaitLists = UserWaitList::with('waitList.schedule.instructor', 'waitList.schedule')->where('user_id', "{$requestUser->id}")->get();
        return view('user', compact('cards', 'purchaseHistory', 'classes', 'previousClasses', 'UserWaitLists', 'bookedClasses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('/register');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'max:60'],
            'last_name' => ['required', 'string', 'max:60'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'max:100', 'confirmed'],
            'birth_date' => ['required', 'date'],
            'phone' => ['required', 'int', 'digits:10'],
            // 'weight' => ['required', 'numeric', 'between:0,999.99'],
            // 'height' => ['required', 'int', 'max:250'],
            'gender' => ['required', 'string', 'max:6', 'in:Hombre,Mujer'],
            'shoe_size' => ['required', 'numeric', 'between:0,32.5'],
            'conditions' => ['required'],
        ];
        $messages = [
            'conditions.required' => "Para continuar, debes aceptar los términos y condiciones.",
            "required" => "Este campo es requerido",
            "numeric" => "Este campo solo acepta numeros",
            "int" => "Este campo solo acepta numeros",
            "confirmed" => "Las contraseñas no coinciden",
            "unique" => "Este usuario ya existe",
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }
        // Available alpha caracters
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        // generate a pin based on 2 * 7 digits + a random character
        $pin = $characters[rand(0, strlen($characters) - 1)]
        . $characters[rand(0, strlen($characters) - 1)]
        . $characters[rand(0, strlen($characters) - 1)]
        . $characters[rand(0, strlen($characters) - 1)];
        // shuffle the result
        $share_code = str_shuffle($pin);

        $user = new User([
            'name' => $request->get('name'),
            'last_name' => $request->get('last_name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'birth_date' => $request->get('birth_date'),
            'phone' => $request->get('phone'),
            //'weight' => $request->get('weight'),
            //'height' => $request->get('height'),
            'gender' => $request->get('gender'),
            'shoe_size' => $request->get('shoe_size'),
            'share_code' => $share_code,
            'customer_id' => null,
            'role_id' => 3,
        ]);
        $user->save();        
        Session::flash('alertTitle', "Registro exitoso");
        Session::flash('alertMessage', "Gracias por unirte a Vèlo");
        Session::flash('alertType', "success");        
        Auth::login($user);
        return redirect()->route('home')->with('success','Data Added');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('/user', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateData(Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'max:60'],
            'last_name' => ['required', 'string', 'max:60'],
            // 'birth_date' => ['required', 'date'],
            'phone' => ['required', 'int', 'digits:10'],
            'shoe_size' => ['required'/*,'min:18','max:35'*/],
        ];
        $messages = [
            "required" => "El campo es requerido",
            "shoe_size.min" => "La talla de tu calzado no es válida"
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $user = $request->user();
        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->phone = $request->phone;
        $user->shoe_size = $request->shoe_size;
        $user->save();
        return redirect('user')->with('success', 'Data has been updated');
    }

    public function updatePassword(Request $request)
    {
        //dd($request->get('password'));
        $request->validate([
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
        $user = User::find(Auth::user()->id);
        $user->password = Hash::make($request->get('password'));
        $user->save();
        return redirect('user')->with('success', 'Data has been updated');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        return $token;
    }

    public function getAuthenticatedUser()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }

        return response()->json(compact('user'));
    }
}
