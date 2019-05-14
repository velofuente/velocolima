<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WaitList extends Model
{
    protected $fillable = [
        'schedule_id',
    ];
    public function schedule(){
        return $this->hasOne(Schedule::class, "id", "schedule_id");
    }
    public function day(){
        return $this->hasOne(Schedule::class, "id", "schedule_id")->select('day');
    }
    public function hour(){
        return $this->hasOne(Schedule::class, "id", "schedule_id")->select('hour');
    }
}
