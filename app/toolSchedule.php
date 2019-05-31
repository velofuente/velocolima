<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ToolSchedule extends Model
{
    protected $fillable = [
        'tool_id', 'schedule_id', 'selected',
    ];
}
