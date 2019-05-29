<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSchedule extends Model
{
    protected $fillable = [
        'user_id', 'schedule_id', 'purchase_id', 'status', 'bike', 'changedSit',
    ];

    public function schedule(){
        return $this->hasOne(Schedule::class, "id", "schedule_id");
    }
}
