<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Employee extends Model
{
    use HasFactory, HasApiTokens;
    use Notifiable, HasRoles;

    protected $guard_name = 'admin';

    protected $fillable = [
        'name', 'last_name', 'dui', 'nit', 'email', 'password', 'phone'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $hidden = [
        'password'
    ];

    public function sale()
    {
        return $this->hasMany('App\Models\Sale');
    }
}
