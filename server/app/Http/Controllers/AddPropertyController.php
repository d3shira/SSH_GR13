<?php

namespace App\Http\Controllers;

use App\Models\Addresses;
use App\Models\Owners;
use App\Models\Features;
use App\Models\Images;
use App\Models\Properties;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;


class AddPropertyController extends Controller
{
    public function getPropertyTypes()
    {
        try {
            $propertyTypes = DB::table('property_types')->select('id', 'property_type_name')->get();
            return response()->json($propertyTypes);
        } catch (\Exception $e) {
            Log::error('Error fetching property types: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        Log::debug('Incoming request data:', $request->all());

        // Validate the request
        $request->validate([
            'form' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        // Decode the JSON form data
        $form = json_decode($request->input('form'), true);

        if (is_null($form)) {
            return response()->json(['error' => 'Invalid form data'], 400);
        }

        // Validate the form data
        $validated = validator($form, [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date_listed' => 'required|date',
            'status' => 'nullable|string',
            'seller_id' => 'required|integer',
            'property_type_id' => 'required|integer',
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
            'owner.contact_info' => 'required|string|max:255'
        ])->validate();

        // Save the address
        $address = new Addresses();
        $address->country = $form['address']['country'];
        $address->municipality = $form['address']['municipality'];
        $address->city_village = $form['address']['city_village'];
        $address->address_line = $form['address']['address_line'];
        $address->postal_code = $form['address']['postal_code'];
        $address->save();

        // Save the features
        $features = new Features();
        $features->num_bedrooms = $form['features']['num_bedrooms'] ?? null;
        $features->num_bathrooms = $form['features']['num_bathrooms'] ?? null;
        $features->square_meters = $form['features']['square_meters'] ?? null;
        $features->floor_number = $form['features']['floor_number'] ?? null;
        $features->has_balcony = $form['features']['has_balcony'] ? 1 : 0;
        $features->has_garden = $form['features']['has_garden'] ? 1 : 0;
        $features->has_garage = $form['features']['has_garage'] ? 1 : 0;
        $features->has_parking = $form['features']['has_parking'] ? 1 : 0;
        $features->has_elevator = $form['features']['has_elevator'] ? 1 : 0;
        $features->price = $form['features']['price'] ?? null;
        $features->save();


        // Save the owner
        $owner = new Owners();
        $owner->owner_name = $form['owner']['owner_name'];
        $owner->contact_info = $form['owner']['contact_info'];
        $owner->save();

        // Save the property
        $property = new Properties();
        $property->title = $form['title'];
        $property->description = $form['description'];
        $dateListed = Carbon::parse($form['date_listed'])->toDateString();
        $property->date_listed = $dateListed;
        $property->status = $form['status'];
        $property->seller_id = $form['seller_id'];
        $property->property_type_id = $form['property_type_id'];
        $property->for_rent = $form['selection'] === 'for_rent' ? 1 : 0; 
        $property->for_sale = $form['selection'] === 'for_sale' ? 1 : 0;

        $property->address_id = $address->id;
        $property->owner_id = $owner->id;
        $property->property_feature_id = $features->id;

        $property->save();


        // Handle image upload
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('property_images'), $imageName);
                // Save image URL to the database
                $imageModel = new Images();
                $imageModel->property_id = $property->id;
                $imagePath = 'property_images/' . $imageName;
                $imageModel->image_url = asset($imagePath);
                $imageModel->save();
            }
        } else {
            Log::debug('No images found in the request.');
        }


        return response()->json(['message' => 'Property added successfully']);
    }


}
