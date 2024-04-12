<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
    use HasFactory;
    protected $primaryKey = 'review_id';
    protected $fillable = [
        'user_id',
        'rating',
        'comment',
    ];
    public function users(): BelongsTo
    {
        return $this->belongsTo(Users::class);
    }
}
