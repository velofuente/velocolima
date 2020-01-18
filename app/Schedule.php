<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use SoftDeletes;

    protected $table = 'schedules';
    protected $guarded = [];

    public function instructorWithTrashed(){
        return $this->hasOne(Instructor::class, 'id','instructor_id')->withTrashed();
    }
    public function instructor(){
        return $this->belongsTo(Instructor::class);
    }

    public function room(){
        return $this->belongsTo(Room::class);
    }

    public function branchWithTrashed(){
        return $this->hasOne(Branch::class, 'id', 'branch_id')->withTrashed();
    }

    public function branch(){
        return $this->hasOne(Branch::class, 'id', 'branch_id');
    }

    public function getTimeAttribute($value)
    {
        return new \DateTime($value);
    }

    public function getHourInstance()
    {
        return new \DateTime($this->hour);
    }
}