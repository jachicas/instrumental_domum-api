<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'payment_method', 'total', 'status'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function saleDetails()
    {
        return $this->hasMany('App\Models\SaleDetail');
    }
}
