<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'last_name', 'dui', 'nit', 'email', 'password', 'phone'
    ];

    protected $hidden = [
        'password'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sale()
    {
        return $this->hasMany('App\Models\Sale');
    }
}
