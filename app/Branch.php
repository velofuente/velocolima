<?php

namespace App;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
//cambio
class Branch extends Model
{
    use SoftDeletes;
    
    protected $table = 'branches';
    protected $guarded = [];

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'branch_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_branches', 'branch_id');
    }

    public function brands() {
        return $this->belongsToMany(Brand::class, 'brand_branches', 'branch_id');
    }
}