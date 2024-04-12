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
        'Address_id', //PropertyAddresses
        'Seller_id',  //Users 
        'Application_id', //Applications
        'Price',
        'Nr_bedrooms',
        'Nr_bathrooms',
        'Square_meters',
        'Description',
        'Status',
       
    ];

    
    public function appointments()
    {
        return $this->hasMany(Appointments::class);
    }

    public function property_addresses(): HasOne
    {
        return $this->hasOne(PropertyAddresses::class);
    }

    public function users(): BelongsTo
    {
        return $this->belongsTo(Users::class);
    }

    public function application(): HasOne
    {
        return $this->hasOne(Applications::class);
    }
}
