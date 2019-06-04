<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\CoachInfo;

class MailSendingController extends Controller
{
    public function coachInfo(Request $request)
    {
        try {
            \Mail::to('pjimenez0@ucol.mx')->send(new CoachInfo($request->name,$request->email,$request->phone,$request->instagram));
            return response()->json([
                'status' => 'OK',
                'message' => "Informacion enviada con exito!",
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'ERROR',
                'message' => "Intentelo mas tarde",
            ]);
        }

    }
}
