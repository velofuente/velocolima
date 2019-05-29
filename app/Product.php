<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'n_classes', 'price', 'description', 'expiration_days', 'type', 'status',
    ];
}
