<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Card;

class CardController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $card = new Card([
            'token_id' => $request->get('token_id'),
            'brand' => $request->get('brand'),
            'card_number' => $request->get('card_number'),
            'holder_name' => $request->get('holder_name'),
            'expiration_year' => $request->get('expiration_year'),
            'expiration_moth' => $request->get('expiration_moth'),
            'bank_name' => $request->get('bank_name'),
            'selected' => $request->get('selected'),
        ]);
        $card->save();
    }
}
