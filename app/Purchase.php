<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [
        'product_id', 'card_id', 'user_id', 'n_classes', 'expiration_days',
    ];
    public function productWithTrashed(){
        return $this->belongsTo(Product::class, 'product_id', 'id')->withTrashed();
    }
    public function product(){
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    public function client(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
