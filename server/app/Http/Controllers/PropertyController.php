<?php

namespace App\Http\Controllers;

use App\Models\Properties;
use App\Models\Images;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PropertyController extends Controller

{
    public function getProperties(Request $request)
    {
        try {
            $properties = Properties::select(
                'properties.id',
                'properties.title',
                'properties.description',
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

                $groupedProperties = $properties->groupBy('id')->map(function ($propertyGroup) {
                    $property = $propertyGroup->first();
                    $property->image_url = $propertyGroup->pluck('image_url')->filter()->first();
                    return $property;
                });

            return response()->json($groupedProperties->values());

        } catch (\Exception $e) {
            Log::error('Error fetching properties: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function filterProperties(Request $request)
    {
        try {
            $category = $request->input('category');
            $status = $request->input('status');
            $type = $request->input('type');
            $city = $request->input('city');

            $properties = Properties::query();

            if ($category) {
                if ($category == 'residential') {
                    $properties->whereIn('property_type_id', [1, 2]); // IDs for residential types
                } elseif ($category == 'business') {
                    $properties->where('property_type_id', 3); // ID for business
                }
            }

            if ($status) {
                if ($status == 'rent') {
                    $properties->where('for_rent', true);
                } elseif ($status == 'sale') {
                    $properties->where('for_sale', true);
                }
            }

            if ($type) {
                $properties->whereHas('propertyType', function($q) use ($type) {
                    $q->where('property_type_name', $type);
                });
            }

            if ($city) {
                $properties->whereHas('address', function($q) use ($city) {
                    $q->where('municipality', $city);
                });
            }

            $properties->select(
                'properties.id',
                'properties.description',
                'addresses.address_line',
                'addresses.municipality',
                'features.num_bedrooms',
                'features.square_meters',
                'features.price',
                'property_types.id',
                'property_types.property_type_name',
                'images.image_url'
            )
            ->leftJoin('addresses', 'properties.address_id', '=', 'addresses.id')
            ->leftJoin('features', 'properties.property_feature_id', '=', 'features.id')
            ->leftJoin('property_types', 'properties.property_type_id', '=', 'property_types.id')
            ->leftJoin('images', 'properties.id', '=', 'images.property_id');


            $filteredProperties = $properties->paginate(6); // Paginate with 6 items per page

            $filteredProperties = $properties->get();

            return response()->json($filteredProperties);
        } catch (\Exception $e) {
            Log::error('Error filtering properties: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function show( $id)
    {
        $property = Properties::select(
            'properties.id',
            'properties.status',
            'properties.description',
            'addresses.address_line',
            'addresses.municipality',
            'features.num_bedrooms',
            'features.num_bathrooms',
            'features.floor_number',
            'features.has_balcony',
            'features.has_garden',
            'features.has_parking',
            'features.has_elevator',
            'features.square_meters',
            'features.price',
            'images.image_url'
        )
        ->leftJoin('addresses', 'properties.address_id', '=', 'addresses.id')
        ->leftJoin('features', 'properties.property_feature_id', '=', 'features.id')
        ->leftJoin('property_types', 'properties.property_type_id', '=', 'property_types.id')
        ->leftJoin('images', 'properties.id', '=', 'images.property_id')
        ->where('properties.id', $id)
        ->first();

        if ($property) {
            $images = Images::where('property_id', $id)->get();
            $property->images = $images;
            return response()->json($property);
        } else {
            return response()->json(['message' => 'Property not found'], 404);
        }
    }
}

