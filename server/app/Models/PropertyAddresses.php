<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyAddresses extends Model
{
    use HasFactory;
    protected $primaryKey = 'property_address_id';
    protected $fillable =[
        'country',
        'municipality',
        'city_town_village',
        'address_line',                                      //must include details like: neighborhood, street name, building name and/or number
        'postal_code',
    ];
}
