<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'last_name', 'dui', 'nit', 'email', 'password', 'phone'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

}
