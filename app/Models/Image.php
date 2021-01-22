<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'image',
    ];

    public function brands()
    {
        return $this->hasMany('App\Models\Brand');
    }

    public function productTypes()
    {
        return $this->hasMany('App\Models\ProductType');
    }

    public function products()
    {
        return $this->hasMany('App\Models\Products');
    }
}
