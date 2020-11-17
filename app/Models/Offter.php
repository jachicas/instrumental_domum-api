<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offter extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'discount', 'status', 'start', 'finish'
    ];

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
