<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    
    protected $fillable = ['role_name'];

    public function abilities()
    {
        return $this->belongsToMany(Ability::class, 'role_ability');
    }

    public function users()
    {
        return $this->hasMany(Users::class);
    }
}
