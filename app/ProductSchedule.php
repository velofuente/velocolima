<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductSchedule extends Model
{
    use SoftDeletes;

    protected $table = 'product_schedules';
    protected $fillable = [
        'product_id',
        'available_days',
        'schedules'
    ];
}
