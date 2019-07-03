<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\CoachInfo;
use App\Mail\walkInRegister;

class MailSendingController extends Controller
{
    public function coachInfo(Request $request)
    {
        try {
            \Mail::to('rueda@velocycling.mx')->send(new CoachInfo($request->name,$request->email,$request->phone,$request->instagram));
            return response()->json([
                'status' => 'OK',
                'message' => "Informacion enviada con éxito!",
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'ERROR',
                'message' => "Intentelo mas tarde",
            ]);
        }
    }
    public function walkInRegister($user_email, $user_name, $user_password)
    {
        try {
            \Mail::to($user_email)->send(new walkInRegister($user_name, $user_email, $user_password));
            return response()->json([
                'status' => 'OK',
                'message' => "Informacion enviada con éxito!",
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'ERROR',
                'message' => "Error". $e->getMessage()
            ]);
        }
    }
}
