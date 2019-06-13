<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'admin_id', 'purchase_id',
    ];
    public function admin(){
        return $this->belongsTo(User::class);
    }

    public function purchase(){
        return $this->belongsTo(Purchase::class, 'purchase_id', 'id');
    }
}
