<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'rooms';
    protected $guarded = [];

    public function branch(){
        return $this->belongsTo(Branch::class);
    }
}