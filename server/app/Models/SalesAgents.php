<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesAgents extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id', 
        'job_position',
        'image'
    ];

    public function user()
    {
        return $this->belongsTo(Users::class, 'user_id');
    }

    public function properties()
    {
        return $this->hasMany(Properties::class, 'seller_id');
    }
}
