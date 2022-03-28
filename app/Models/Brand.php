<?php

namespace App\Models;

use App\Branch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use SoftDeletes;

    protected $table = 'brands';

    protected $fillable = [
        'franchise_id',
        'name',
        'active'
    ];

    public function branches()
    {
        return $this->belongsToMany(Branch::class, 'brand_branches', 'brand_id')
            ->withPivot('active');
    }
}
