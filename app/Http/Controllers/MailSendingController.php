<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\{CoachInfo, walkInRegister, addtionalFreeClass, BirthdayEmail};
use Illuminate\Support\Facades\Log;

class MailSendingController extends Controller
{
    public function coachInfo(Request $request)
    {
        if( is_null($request->name) ){
            return response()->json([
                'status' => 'Error',
                'message' => 'El campo "Nombre" es requerido.'
            ]);
        } else if(is_null($request->email)){
            return response()->json([
                'status' => 'Error',
                'message' => 'El campo "Email" es requerido.'
            ]);
        } else if( is_null($request->phone) ){
            return response()->json([
                'status' => 'Error',
                'message' => 'El campo "Teléfono" es requerido.'
            ]);
        } else if(is_null($request->instagram)){
            return response()->json([
                'status' => 'Error',
                'message' => 'El campo "Instagram" es requerido.'
            ]);
        }
        try {
            \Mail::to('rueda@velocycling.mx')->send(new CoachInfo($request->name,$request->email,$request->phone,$request->instagram));
            return response()->json([
                'status' => 'OK',
                'message' => "¡Informacion enviada con éxito!",
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'ERROR',
                'message' => "Inténtelo mas tarde",
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
    public function addtionalFreeClass($user_email, $user_name)
    {
        try {
            \Mail::to($user_email)->send(new addtionalFreeClass($user_name));
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
    public function birthdayEmail($user_email, $user_name)
    {
        try {
            \Mail::to($user_email)->send(new BirthdayEmail($user_name));
            return response()->json([
                'status' => 'OK',
                'message' => "Informacion enviada con éxito!",
            ]);
        } catch (Exception $e) {
            log::info($e->getMessage());
            return response()->json([
                'status' => 'ERROR',
                'message' => "Error". $e->getMessage()
            ]);
        }
    }
}
