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

    // Metoda për të lidhur tabelën e adresave të pronave
    public function propertyAddress()
    {
        return $this->belongsTo(PropertyAddress::class);
    }
}
