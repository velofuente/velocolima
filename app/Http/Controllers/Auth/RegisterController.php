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
        //{{dd($data);}}
        return Validator::make($data, [
            //Previous validator names
            // 'name' => ['required', 'string', 'max:60'],
            // 'apellido_p' => ['required', 'string', 'max:60'],
            // 'apellido_m' => ['required', 'string', 'max:60'],
            // 'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            // 'password' => ['required', 'string', 'min:8', 'confirmed'],
            // 'fecha_nac' => ['required', 'date'],
            // 'telefono' => ['required', 'int', 'max:999999999999999'],
            // 'peso' => ['required', 'numeric', 'between:0,999.99'],
            // 'estatura' => ['required', 'int', 'max:250'],
            // 'n_clases' => ['required', 'int', 'max:999'],
            // 'genero' => ['required', 'string', 'max:6'],
            // 'expiracion' => ['required', 'date'],
            //Actual validator names; n_clases & expiracion were deleted
            'name' => ['required', 'string', 'max:60'],
            'last_name' => ['required', 'string', 'max:60'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'birth_date' => ['required', 'date'],
            'phone' => ['required', 'int', 'max:999999999999999'],
            'weight' => ['required', 'numeric', 'between:0,999.99'],
            'height' => ['required', 'int', 'max:250'],
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
            'gender' => $data['gender'],
        ]);
    }
}
