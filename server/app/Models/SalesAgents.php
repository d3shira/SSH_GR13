<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesAgents extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(Users::class, 'user_id');
    }
}
