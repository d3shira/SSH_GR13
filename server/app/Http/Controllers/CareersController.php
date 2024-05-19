<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Careers;
use Illuminate\Support\Facades\Validator;

class CareersController extends Controller
{
    public function store(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'birthday' => 'required|date',
            'nationality' => 'required|string|max:255',
            'personal_number' => 'required|numeric',
            'email' => 'required|email|max:255',
            'message' => 'nullable|string|max:1000'
        ]);

       
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

       
        $career = new Careers();
        $career->fill($request->all());
        $career->save();

   
        return response()->json(['message' => 'Form submitted successfully', 'data' => $career], 201);
    }
}
