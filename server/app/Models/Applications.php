<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $primaryKey = 'application_id'; // Ndryshimi i primary key nëse është e nevojshme
    protected $fillable = [
        'user_id',
        'type',
        'owner_name',
        'document',
        'for_rent',
        'for_sale',
        'property_address_id',
        'price',
        'bedrooms',
        'bathrooms',
        'square_meters',
        'description',
        'status',
    ];

    public function users()
    {
        return $this->belongsTo(Users::class);
    }
    public function properties(): BelongsTo
    {
        return $this->belongsTo(Properties::class);
    }
}
