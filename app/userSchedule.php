<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class userSchedule extends Model
{
    protected $fillable = [
        'user_id', 'schedule_id', 'purchase_id',
    ];
}
