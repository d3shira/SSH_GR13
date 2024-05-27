<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Users extends Authenticatable implements JWTSubject
{
    use HasFactory;
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function ability()
    {
        return $this->belongsTo(Ability::class, 'ability_id');
    }
    public function salesAgent()
    {
        return $this->hasOne(SalesAgents::class, 'user_id');
    }


    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'phone',
        'password',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

}
