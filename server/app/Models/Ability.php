<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ability extends Model
{

    use HasFactory;

    protected $fillable = ['ability_name'];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_ability');
    }

    public function users()
    {
        return $this->hasMany(Users::class);
    }
}