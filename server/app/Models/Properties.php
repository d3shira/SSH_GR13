<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Properties extends Model
{
    use HasFactory;
    protected $primaryKey = 'Property_id';
    protected $fillable = [
        'Type',
        'For_rent',
        'For_sale',
        'Address_id',
        'Seller_id',
        'Application_id',
        'Price',
        'Nr_bedrooms',
        'Nr_bathrooms',
        'Square_meters',
        'Description',
        'Status',
       
    ];
}
