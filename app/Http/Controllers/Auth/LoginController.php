<?php

namespace App\Http\Controllers\Auth;
use Auth, Session;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Log;
use function GuzzleHttp\json_encode;
use App\User;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest', ['only' => 'showLoginForm']);
    }

    /**
     * Desplegar vista para iniciar sesión
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Función para realizar intento de inicio de sesión
     *
     * @param Request $request
     * @return mixed
     */
    public function login(Request $request)
    {
        $credentials = $this->validate(request(),[
            'email' => 'email|required|string',
            'password' => 'required|string'
        ]);
        //return $credentials;
        if (Auth::attempt($credentials)) {
            //Bearer Token
            //$tokenBearer = app('App\Http\Controllers\UserController')->authenticate($request);
            //Session::push("tokenBearer", $tokenBearer);
            //dd($tokenBearer);

            // $_SESSION["tokenasd"] = $tokenBearer->getData();
            // dd($_SESSION["tokenasd"]);

            // $value = session('key');
            // $value = session('key', 'default');
            // session(['key' => $_SESSION["tokenasd"]]);
            // //En Vista
            // $value = $request->session()->get('key');
            // dd($value);
            $user = User::where('email', $request->email)->first();
            if($user->role_id == 1){
                log::info($user->role_id);
                return redirect("/admin");
            }
            else
                return redirect("/user");
        }
        return back()
            ->withErrors([
                'email' => "Formato de e-mail no valido",
                'required' => "Campo requerido",
                'password' => "Credenciales no válidas",
            ])
            ->withInput(request(['email']));
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    /**
    * The user has been authenticated.
    *
    * @param \Illuminate\Http\Request $request
    * @param mixed $user
    * @return mixed
    */
    public function authenticated(Request $request, $user)
    {
        if (!$user->verified) {
            auth()->logout();
            return back()->with('warning', 'You need to confirm your account. We have sent you an activation code, please check your email.');
        }
        return redirect()->intended($this->redirectPath());
    }
}
