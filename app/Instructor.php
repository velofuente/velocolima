<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    //

    protected $fillable = [
        'name', 'last_name', 'email', 'birth_date', 'phone', 'bio',
    ];
}
