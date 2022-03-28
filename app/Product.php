<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'n_classes', 'price', 'description', 'expiration_days', 'type', 'status', 'cancelation_range', 'is_refundable', 'day_count_limit'
    ];

    public function productSchedule()
    {
        return $this->hasOne('App\ProductSchedule', 'product_id');
    }

    public function scopeCatalog()
    {
        return $this->selectRaw("id, IF(NOT ISNULL(n_classes), n_classes, 'N/A') AS n_classes, price, description, IF(NOT ISNULL(expiration_days), CONCAT(expiration_days, ' días'), 'N/A') AS expiration_days, CASE type WHEN 'free' THEN 'Clase gratis'  WHEN 'Packages' THEN 'Paquete' WHEN 'Deals' THEN 'Promoción' ELSE 'Mercancía' END AS type, CASE status WHEN 1 THEN 'Habilitado' ELSE 'Deshabilitado' END AS status");
    }

    public function schedules() {
        return $this->hasMany(ProductSchedule::class);
    }

    public function branches()
    {
        return $this->belongsToMany(Product::class, 'product_branches', 'product_id');
    }
}
