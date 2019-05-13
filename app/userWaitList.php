<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class userWaitList extends Model
{
    protected $fillable = [
        'user_id', 'wait_list_id',
    ];
}
