<?php

namespace App\Http\Controllers\Auth;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest', ['only' => 'showLoginForm']);
    }
    public function showLoginForm()
    {
        return  view('auth.login');
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
            app('App\Http\Controllers\UserController')->authenticate($request);
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
}
