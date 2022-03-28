<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    protected $table = 'places';

    protected $fillable = ['name', 'time_zone', 'active'];

    public function franchises()
    {
        return $this->belongsToMany(Franchise::class, 'franchise_places', 'place_id')
            ->withPivot('active');
    }
}
