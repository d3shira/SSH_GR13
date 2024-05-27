<?php

namespace App\Http\Controllers;

use App\Models\Properties;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/properties/filter",
     *     summary="Filter properties based on query parameters",
     *     @OA\Parameter(
     *         name="query",
     *         in="query",
     *         description="Search query for property description or address",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="propertyType",
     *         in="query",
     *         description="Type of property (sale or rent)",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="propertyCategory",
     *         in="query",
     *         description="Category of property (residential or business)",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Filtered properties list"),
     *     @OA\Response(response="500", description="Server error")
     * )
     */
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
                'properties.title',
                'properties.property_type_id',
                'properties.for_sale',
                'properties.for_rent',
                'properties.description',
                'property_types.property_type_name',
                'addresses.address_line',
                'addresses.municipality',
                'features.price',
                'images.image_url'
            )
            ->leftJoin('addresses', 'properties.address_id', '=', 'addresses.id')
            ->leftJoin('property_types', 'properties.property_type_id', '=', 'property_types.id')
            ->leftJoin('features', 'properties.property_feature_id', '=', 'features.id')
            ->leftJoin('images', 'properties.id', '=', 'images.property_id');

            $filteredProperties = $properties->get();

            $groupedProperties = $filteredProperties->groupBy('id')->map(function ($propertyGroup) {
                $property = $propertyGroup->first();
                $property->images = $propertyGroup->pluck('image_url')->filter()->toArray();
                return $property;
            });

            return response()->json($groupedProperties->values());

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
