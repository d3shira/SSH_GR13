<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Features extends Model
{
    use HasFactory;

    public function properties()
    {
        return $this->hasMany(Properties::class, 'property_feature_id');
    }
}
