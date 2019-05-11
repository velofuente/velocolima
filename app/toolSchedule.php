<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class toolSchedule extends Model
{
    protected $fillable = [
        'tool_id', 'schedule_id', 'selected',
    ];
}
