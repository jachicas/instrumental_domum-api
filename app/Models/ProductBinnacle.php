<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductBinnacle extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'employee_id', 'description', 'action'
    ];

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

    public function employee()
    {
        return $this->belongsTo('App\Models\Employee');
    }
}
