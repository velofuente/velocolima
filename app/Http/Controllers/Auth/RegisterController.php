<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Role;
use App\Cart;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'min:3' , 'max:60'],
            'last_name' => ['required', 'string', 'min:3', 'max:60'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:7', 'max:100', 'confirmed'],
            'birth_date' => ['required', 'date'],
            'phone' => ['required', 'int', 'max:999999999999999'],
            'weight' => ['required', 'numeric', 'between:0,999.99'],
            'height' => ['required', 'int', 'max:250'],
            'shoe_size' => ['required', 'numeric', 'between: 10.0, 34.5'],
            'gender' => ['required', 'string', 'max:6'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'birth_date' => $data['birth_date'],
            'phone' => $data['phone'],
            'weight' => $data['weight'],
            'height' => $data['height'],
            'shoe_size' => $data['shoe_size'],
            'gender' => $data['gender']
        ]);
    }
}
