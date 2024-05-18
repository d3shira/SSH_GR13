<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Properties extends Model
{
    use HasFactory;

    public function propertyType()
    {
        return $this->belongsTo(PropertyTypes::class, 'property_type_id');
    }

    public function address()
    {
        return $this->belongsTo(Addresses::class, 'address_id');
    }

    public function seller()
    {
        return $this->belongsTo(SalesAgents::class, 'seller_id');
    }

    public function owner()
    {
        return $this->belongsTo(Owners::class, 'owner_id');
    }

    public function propertyFeature()
    {
        return $this->belongsTo(Features::class, 'property_feature_id');
    }
}
