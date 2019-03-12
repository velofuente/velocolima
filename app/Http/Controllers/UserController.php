<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user');
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
        //dd($request);

        $this->validate($request, [
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

        // Available alpha caracters
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        // generate a pin based on 2 * 7 digits + a random character
        $pin = mt_rand(10000, 99999)
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
            'weight' => $request->get('weight'),
            'height' => $request->get('height'),
            'gender' => $request->get('gender'),
            'share_code' => $share_code
        ]);
        //dd($user);
        $user->save();
        return redirect()->route('user.index')->with('success','Data Added');
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
    public function update(Request $request, $id)
    {
        //dd($request->get('name'));
        $request->validate([
            'name' => ['required', 'string', 'max:60'],
            'last_name' => ['required', 'string', 'max:60'],
            'phone' => ['required', 'int', 'max:999999999999999'],
        ]);
        $user = User::find($id);
        $user->name = $request->get('name');
        $user->last_name = $request->get('last_name');
        $user->phone = $request->get('phone');
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
}
