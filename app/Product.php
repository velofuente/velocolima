<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'n_classes', 'price', 'description', 'expiration_days', 'type', 'status', 'cancelation_range'
    ];

    public function productSchedule()
    {
        return $this->hasOne('App\ProductSchedule', 'product_id');
    }
}
