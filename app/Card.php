<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $table = 'cards';
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    protected $fillable = [
        'token_id', 'brand', 'card_number', 'holder_name', 'expiration_year', 'expiration_moth','bank_name','selected',"user_id",
    ];

}
