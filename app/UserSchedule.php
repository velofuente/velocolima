<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSchedule extends Model
{
    protected $fillable = [
        'user_id', 'schedule_id', 'purchase_id', 'status', 'bike', 'changedSit',
    ];
    public function scheduleWithTrashed(){
        return $this->hasOne(Schedule::class, "id", "schedule_id")->withTrashed();
    }
    public function schedule(){
        return $this->hasOne(Schedule::class, "id", "schedule_id");
    }
    public function user(){
        return $this->hasOne(User::class, "id", "user_id");
    }
    public function purchase(){
        return $this->hasOne(Purchase::class, "id", "purchase_id");
    }
}
