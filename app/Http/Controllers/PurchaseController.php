<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Purchase;

class PurchaseController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $requestUser = $request->user();
        $charge = app('App\Http\Controllers\OpenPayController')->makeChargeCustomer($requestUser->id,$requestUser->customer_id,$request->price,$request->description,$request->device_session_id);
        $card = new Purchase([
            'product_id' => $request->product_id,
            'card_id' => $charge->card->id,
            'user_id' => $requestUser->product_id
        ]);
        $card->save();
        return "Cargo exitoso";
    }
}
