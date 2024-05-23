<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Applications;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'nullable|string|max:1000'
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Create and save the application
        $application = new Applications();
        $application->fill($request->all());
        $application->save();

        // Return success response
        return response()->json(['message' => 'Application submitted successfully', 'data' => $application], 201);
    }
}
