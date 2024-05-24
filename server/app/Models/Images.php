<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    use HasFactory;
    protected $fillable = ['property_id', 'image_url'];

    public function property()
    {
        return $this->belongsTo(Properties::class);
    }
}
