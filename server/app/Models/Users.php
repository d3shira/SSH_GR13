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

   

       // Method to check ability
       public function hasAbility($ability)
       {
           // Check if ability relationship is loaded and not null
           return $this->ability && $this->ability->ability_name === $ability;
       }

    public function hasRole($roleName)
{
    return $this->role()->where('role_name', $roleName)->exists();
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
