<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
//cambio
class Branch extends Model
{
    use SoftDeletes;
    protected $table = 'branches';
    protected $guarded = [];
}