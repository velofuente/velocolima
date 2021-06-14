<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CardAttempt extends Model
{
    protected $table = 'card_attempts';
    protected $fillable = ['user_id', 'attempts', 'date'];

    protected $dates = ['date'];

}
