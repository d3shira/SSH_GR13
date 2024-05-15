<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abilities extends Model
{
    use HasFactory;

    protected $primaryKey = 'ability_id'; 
    protected $fillable = ['ability_name']; 
    public $timestamps = true; 
}