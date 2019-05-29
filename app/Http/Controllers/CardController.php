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
    public function store($card, $user_id)
    {
        $card = new Card([
            'token_id' => $card->id,
            'card_number' => $card->card->card_number,
            'holder_name' => $card->card->holder_name,
            'expiration_year' => $card->card->expiration_year,
            'expiration_moth' => $card->card->expiration_month,
            'brand' => $card->card->brand,
            'selected' => 1,
            'user_id' => $user_id
        ]);
        $card->save();
    }
}
