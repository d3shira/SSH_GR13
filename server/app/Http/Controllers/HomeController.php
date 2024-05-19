<?php

namespace App\Http\Controllers;

use App\Models\Properties;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function filter(Request $request)
    {
        try {
            $query = $request->input('query');
            $propertyType = $request->input('propertyType');
            $propertyCategory = $request->input('propertyCategory');

            $properties = Properties::query();

            if ($query) {
                $properties->where(function($q) use ($query) {
                    $q->where('description', 'like', '%' . $query . '%')
                    ->orWhere('addresses.address_line', 'like', '%' . $query . '%')
                    ->orWhere('addresses.municipality', 'like', '%' . $query . '%');
                });
            }

            if ($propertyType) {
                if ($propertyType == 'sale') {
                    $properties->where('for_sale', true);
                } elseif ($propertyType == 'rent') {
                    $properties->where('for_rent', true);
                }
            }

            if ($propertyCategory) {
                if ($propertyCategory == 'residential') {
                    $properties->whereIn('property_type_id', [1, 2]); // 1 and 2 are IDs for home and apartment
                } elseif ($propertyCategory == 'business') {
                    $properties->where('property_type_id', 3); // 3 is the ID for business
                }
            }

            $properties->select(
                'properties.id',
                'properties.property_type_id',
                'properties.for_sale',
                'properties.for_rent',
                'properties.description',
                'property_types.property_type_name',
                'addresses.address_line',
                'addresses.municipality',
                'features.price'
            )
            ->leftJoin('addresses', 'properties.address_id', '=', 'addresses.id')
            ->leftJoin('property_types', 'properties.property_type_id', '=', 'property_types.id')
            ->leftJoin('features', 'properties.property_feature_id', '=', 'features.id');

            $filteredProperties = $properties->get();

            return response()->json($filteredProperties);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
