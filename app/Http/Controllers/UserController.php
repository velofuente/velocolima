<?php

namespace App\Http\Controllers;
use App\{User, Card, Purchase, userSchedule, UserWaitList, waitList, Schedule, Instructor};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Exceptions\JWTException;
use Auth, Log, JWTAuth, DB, Validator, Session;

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
        $purchaseHistory = Purchase::with(['product'])->select("*", DB::raw("DATE_ADD(created_at, INTERVAL expiration_days DAY) finalDate"))->where('user_id', '=', "{$requestUser->id}")->get()->sortByDesc('created_at');
        //return $purchaseHistory = DB::table('purchases')->select("*", DB::raw("DATE_ADD(created_at, INTERVAL expiration_days DAY) finalDate"))->where('user_id', '=', "{$requestUser->id}")->get();
        $cards = DB::table('cards')->where('user_id', '=', "{$requestUser->id}")->get();
        $numClases = DB::table('purchases')->select(DB::raw('SUM(n_classes) as clases'))->where('user_id', '=', "{$requestUser->id}")->first();
        $classes = $numClases->clases;
        $bookedClasses = UserSchedule::with("schedule.instructor", "schedule.room", "schedule")->where('user_id', "{$requestUser->id}")->where('status', 'active')->get();
        $previousClasses = UserSchedule::where('user_id', "{$requestUser->id}")->whereNotIn("status", ["active"])->whereRaw("created_at < NOW()")->get();
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
    public function tesst()
    {
        // return User::select(DB::raw("created_at, DATE_ADD(created_at, INTERVAL 50 HOUR) finalDate"))->get();
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
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'birth_date' => ['required', 'date'],
            'phone' => ['required', 'int', 'max:999999999999999'],
            // 'weight' => ['required', 'numeric', 'between:0,999.99'],
            // 'height' => ['required', 'int', 'max:250'],
            'gender' => ['required', 'string', 'max:6', 'in:Hombre,Mujer'],
            'shoe_size' => ['required', 'numeric', 'between:0,32.5'],
        ];
        $messages = [
            "required" => "Este campo es requerido",
            "numeric" => "Este campo solo acepta numeros",
            "int" => "Este campo solo acepta numeros",
            "confirmed" => "Las contraseñas o coinciden",
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
        ]);
        $user->save();
        $product = DB::table('products')->where('type', 'Deals')->first();
        $deal = new Purchase([
            'product_id' => $product->id,
            'user_id' => $user->id,
            'n_classes' => $product->n_classes,
            'expiration_days' => $product->expiration_days,
        ]);
        $deal->save();
        Session::flash('alertTitle', "Clase Gratis!");
        Session::flash('alertMessage', "Gracias por unirte a Vèlo, tu primera clase va por nuestra cuenta!");
        Session::flash('alertType', "success");
        // Session::flash('alertButton', "Aceptar");
        Auth::login($user);
        Log::info("Entra pre Mail Send");
        // Mail::send([], [], function ($message) use ($request){
        //     $message->to($request->email)
        //       ->subject("Welcome")
        //       // here comes what you want
        //     //   ->setBody('Hi, welcome user!'); // assuming text/plain
        //       // or:
        //       ->setBody('<h1>Hi, welcome user!</h1>', 'text/html'); // for HTML rich messages
        //   });
          Log::info("Entra pos Mail Send");
        return redirect()->route('home')->with('success','Data Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
            'phone' => ['required', 'int', 'max:999999999999999'],
            'shoe_size' => ['required'/*,'min:18','max:35'*/],
        ];
        $messages = [
            "required" => "El campo es requerido",
            "shoe_size.min" => "La talla de tu calzado no es válida"
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }
        $user = $request->user();
        $user->name = $request->name;
        $user->last_name = $request->last_name;
         $user->phone = $request->phone;
        $user->shoe_size = $request->shoe_size;
        $user->save();
        return redirect('user')->with('success', 'Data has been updated');
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

            if (! $user = JWTAuth::parseToken()->authenticate()) {
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
