<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;
    protected $primaryKey = 'user_id';
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'salt',
        'password',
        'phone_number',
        'type',
    ];

    public function applications()
    {
        return $this->hasMany(Applications::class);
    }
    public function properties(): HasMany
    {
        return $this->hasMany(Properties::class);
    }
    public function reviews(): HasMany
    {
        return $this->hasMany(Reviews::class);
    }
}
