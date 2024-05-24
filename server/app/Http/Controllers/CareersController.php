<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Careers;
use Illuminate\Support\Facades\Validator;

class CareersController extends Controller
{
    public function store(Request $request)
    {
        // Validation rules for form fields
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'birthday' => 'required|date',
            'nationality' => 'required|string|max:255',
            'personal_number' => 'required|numeric',
            'email' => 'required|email|max:255',
            'message' => 'nullable|string|max:1000',
            'resume' => 'required|mimes:pdf,doc,docx|max:4096', 
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Handle file upload
        if ($request->hasFile('resume')) {
            $file = $request->file('resume');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('resumes'), $fileName);
            $resumePath = 'resumes/' . $fileName;
        } else {
            return response()->json(['errors' => ['resume' => 'The resume field is required.']], 422);
        }

        
        $career = new Careers();
        $career->name = $request->input('name');
        $career->surname = $request->input('surname');
        $career->birthday = $request->input('birthday');
        $career->nationality = $request->input('nationality');
        $career->personal_number = $request->input('personal_number');
        $career->email = $request->input('email');
        $career->message = $request->input('message', '');
        $career->resume = asset($resumePath); 
        $career->save();

        return response()->json(['message' => 'Form submitted successfully', 'data' => $career], 201);
    }
}
