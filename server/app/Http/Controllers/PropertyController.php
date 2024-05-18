<?php

namespace App\Http\Controllers;

use App\Models\Properties;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PropertyController extends Controller
{
    public function getProperties(Request $request)
    {
        try {
            $properties = Properties::select(
                'properties.id',
                'addresses.address_line',
                'addresses.municipality',
                'features.num_bedrooms',
                'features.square_meters',
                'features.price',
                'images.image_url'
            )
                ->leftJoin('addresses', 'properties.address_id', '=', 'addresses.id')
                ->leftJoin('features', 'properties.property_feature_id', '=', 'features.id')
                ->leftJoin('images', 'properties.id', '=', 'images.property_id')
                ->get();

            return response()->json($properties);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
