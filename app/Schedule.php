<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use SoftDeletes;

    protected $table = 'schedules';
    protected $guarded = [];

    public function instructor(){
        return $this->belongsTo(Instructor::class);
    }

    public function room(){
        return $this->belongsTo(Room::class);
    }

    public function branch(){
        return $this->hasOne(Branch::class, 'id', 'branch_id');
    }

}