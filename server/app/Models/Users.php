<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function ability()
    {
        return $this->belongsTo(Abilities::class, 'ability_id');
    }
    public function salesAgent()
    {
        return $this->hasOne(SalesAgents::class, 'user_id');
    }
}
