<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest', ['only' => 'showLoginForm'])->except('logout');
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
        if (Auth::attempt($credentials)) {
            $user = User::where('email', $request->email)->first();
            if($user->role_id == 1){
                return redirect("/admin");
            }
            return redirect("/user");
        }
        return back()->withErrors([
            // 'email' => "Formato de e-mail no valido",
            'required' => "Campo requerido",
            'password' => "Credenciales no válidas",
        ])->withInput(request(['email']));
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
