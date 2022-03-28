<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Franchise extends Model
{
    use SoftDeletes;

    protected $table = 'franchises';

    protected $fillable = [
        'bussines_name',
        'address',
        'int_number',
        'ext_number',
        'legal_representative',
        'municipality',
        'country',
        'postal_code',
        'phone',
        'email',
        'active'
    ];

    public function places()
    {
        return $this->belongsToMany(Place::class, 'franchise_places', 'franchise_id')
            ->withPivot('active');
    }

    public function brands()
    {
        return $this->hasMany(Brand::class, 'franchise_id');
    }
}
