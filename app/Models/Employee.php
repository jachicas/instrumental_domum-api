<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class Employee extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, HasApiTokens;
    use Notifiable, HasRoles;

    protected $guard_name = 'employee';

    protected $fillable = [
        'name',
        'last_name',
        'dui',
        'nit',
        'birthdate',
        'email',
        'password',
        'phone',
        'vefirication_code',
        'is_verified'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $hidden = [
        'password', 'remeber_token'
    ];

    public function sale()
    {
        return $this->hasMany('App\Models\Sale');
    }

    public function productBinnacles()
    {
        return $this->hasMany('App\Models\ProductBinnacle');
    }
}
