<?php

namespace App\Http\Controllers\Auth;
use Auth, Session;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use function GuzzleHttp\json_encode;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest', ['only' => 'showLoginForm']);
    }
    public function showLoginForm()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $credentials = $this->validate(request(),[
            'email' => 'email|required|string',
            'password' => 'required|string'
        ]);
        //return $credentials;
        if(Auth::attempt($credentials))
        {
            //Bearer Token
            $tokenBearer = app('App\Http\Controllers\UserController')->authenticate($request);
            Session::push("tokenBearer", $tokenBearer);
            // $_SESSION["tokenasd"] = $tokenBearer->getData();
            // dd($_SESSION["tokenasd"]);

            // $value = session('key');
            // $value = session('key', 'default');
            // session(['key' => $_SESSION["tokenasd"]]);
            // //En Vista
            // $value = $request->session()->get('key');
            // dd($value);

            return redirect()->route('user.index');
        }
        return back()
            ->withErrors(['email' => trans('auth.failed')])
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
