<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Instructor extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'last_name', 'email', 'birth_date', 'phone', 'bio',
    ];

    public function schedules(){
        return $this->hasMany(Schedule::class);
    }
}
