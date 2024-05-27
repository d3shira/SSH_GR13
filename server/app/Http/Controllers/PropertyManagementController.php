<?php
namespace App\Http\Controllers;

use App\Models\Addresses;
use App\Models\Features;
use App\Models\Owners;
use App\Models\Properties;
use App\Models\PropertyTypes;
use App\Models\SalesAgents;
use App\Models\Images;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PropertyManagementController extends Controller
{
    public function getProperties(Request $request)
    {
        try {
            $properties = Properties::select(
                'properties.id',
                'properties.title',
                'properties.description',
                'properties.status',
                'addresses.address_line',
                'addresses.municipality',
                'addresses.city_village',
                'addresses.country',
                'addresses.postal_code',
                'features.num_bedrooms',
                'features.num_bathrooms',
                'features.floor_number',
                'features.has_balcony',
                'features.has_garden',
                'features.has_garage',
                'features.has_parking',
                'features.has_elevator',
                'features.square_meters',
                'features.price',
                'property_types.property_type_name',
                'owners.owner_name',
                'owners.contact_info',
                'users.first_name as agent_name',
                'users.phone as agent_contact_info',
                'images.image_url'
            )
                ->leftJoin('addresses', 'properties.address_id', '=', 'addresses.id')
                ->leftJoin('features', 'properties.property_feature_id', '=', 'features.id')
                ->leftJoin('property_types', 'properties.property_type_id', '=', 'property_types.id')
                ->leftJoin('owners', 'properties.owner_id', '=', 'owners.id')
                ->leftJoin('sales_agents', 'properties.seller_id', '=', 'sales_agents.id')
                ->leftJoin('users', 'sales_agents.user_id', '=', 'users.id')
                ->leftJoin('images', 'properties.id', '=', 'images.property_id')
                ->get();
    
            $groupedProperties = $properties->groupBy('id')->map(function ($propertyGroup) {
                $property = $propertyGroup->first();
                $property->image_urls = $propertyGroup->pluck('image_url')->filter()->all();
                return $property;
            });
    
            return response()->json($groupedProperties->values());
        } catch (\Exception $e) {
            Log::error('Error fetching properties: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    

    // Fetch a single property with related details
    public function show($id)
    {
        try {
            $property = Properties::select(
                'properties.id',
                'properties.title',
                'properties.description',
                'properties.status',
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
                'property_types.property_type_name',
                'owners.owner_name',
                'owners.contact_info',
                'users.first_name as agent_name',
                'users.phone as agent_contact_info',
                'images.image_url'
            )
                ->leftJoin('addresses', 'properties.address_id', '=', 'addresses.id')
                ->leftJoin('features', 'properties.property_feature_id', '=', 'features.id')
                ->leftJoin('property_types', 'properties.property_type_id', '=', 'property_types.id')
                ->leftJoin('owners', 'properties.owner_id', '=', 'owners.id')
                ->leftJoin('sales_agents', 'properties.seller_id', '=', 'sales_agents.id')
                ->leftJoin('users', 'sales_agents.user_id', '=', 'users.id')
                ->leftJoin('images', 'properties.id', '=', 'images.property_id')
                ->where('properties.id', $id)
                ->first();

            if ($property) {
                $images = Images::where('property_id', $id)->get();
                $property->images = $images->pluck('image_url');

                return response()->json($property);
            } else {
                return response()->json(['message' => 'Property not found'], 404);
            }
        } catch (\Exception $e) {
            Log::error('Error fetching property details: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        Log::debug('Incoming request data:', $request->all());
    
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'nullable|string',
            'address.country' => 'required|string|max:255',
            'address.municipality' => 'required|string|max:255',
            'address.city_village' => 'required|string|max:255',
            'address.address_line' => 'required|string|max:255',
            'address.postal_code' => 'required|string|max:20',
            'features.num_bedrooms' => 'nullable|integer',
            'features.num_bathrooms' => 'nullable|integer',
            'features.square_meters' => 'nullable|integer',
            'features.floor_number' => 'nullable|integer',
            'features.has_balcony' => 'boolean',
            'features.has_garden' => 'boolean',
            'features.has_garage' => 'boolean',
            'features.has_parking' => 'boolean',
            'features.has_elevator' => 'boolean',
            'features.price' => 'nullable|numeric',
            'owner.owner_name' => 'required|string|max:255',
            'owner.contact_info' => 'required|string|max:255',
            'sales_agent.agent_name' => 'required|string|max:255',
            'sales_agent.contact_info' => 'required|string|max:255',
        ]);
    
        DB::beginTransaction();
    
        try {
            $property = Properties::find($id);
            if (!$property) {
                return response()->json(['message' => 'Property not found'], 404);
            }
    
            // Update the property
            $property->title = $request->input('title');
            $property->description = $request->input('description');
            $property->status = $request->input('status');
            $property->save();
    
            // Update the address
            $address = Addresses::find($property->address_id);
            $address->country = $request->input('address.country');
            $address->municipality = $request->input('address.municipality');
            $address->city_village = $request->input('address.city_village');
            $address->address_line = $request->input('address.address_line');
            $address->postal_code = $request->input('address.postal_code');
            $address->save();
    
            // Update the features
            $features = Features::find($property->property_feature_id);
            $features->num_bedrooms = $request->input('features.num_bedrooms');
            $features->num_bathrooms = $request->input('features.num_bathrooms');
            $features->square_meters = $request->input('features.square_meters');
            $features->floor_number = $request->input('features.floor_number');
            $features->has_balcony = $request->input('features.has_balcony');
            $features->has_garden = $request->input('features.has_garden');
            $features->has_garage = $request->input('features.has_garage');
            $features->has_parking = $request->input('features.has_parking');
            $features->has_elevator = $request->input('features.has_elevator');
            $features->price = $request->input('features.price');
            $features->save();
    
            // Update the owner
            $owner = Owners::find($property->owner_id);
            $owner->owner_name = $request->input('owner.owner_name');
            $owner->contact_info = $request->input('owner.contact_info');
            $owner->save();
    
            // Update the sales agent
            $salesAgent = SalesAgents::find($property->seller_id);
            $salesAgent->agent_name = $request->input('sales_agent.agent_name');
            $salesAgent->contact_info = $request->input('sales_agent.contact_info');
            $salesAgent->save();
    
            DB::commit();
    
            return response()->json(['message' => 'Property updated successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating property: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
}
?>