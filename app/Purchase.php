<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [
        'product_id', 'card_id', 'user_id', 'n_classes', 'expiration_days',
    ];
}
