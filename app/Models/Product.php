<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'product_type_id', 'brand_id', 'status', 'quantity', 'price'
    ];

    public function productType()
    {
        return $this->belongsTo('App\Models\ProductType');
    }

    public function brand()
    {
        return $this->belongsTo('App\Models\Brand');
    }

    public function offter()
    {
        return $this->hasOne('App\Models\Offter');
    }

    public function saleDetail()
    {
        return $this->hasMany('App\Models\SaleDetail');
    }

    public function productBinnacles()
    {
        return $this->hasMany('App\Models\ProductBinnacle');
    }
}
