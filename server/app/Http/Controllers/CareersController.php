<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Careers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

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

    //GET JOB APPLICATIONS
    
    public function getJobApplications()
    {
        try {
            $jobApplications = Careers::all();
            return response()->json($jobApplications);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to fetch job applications.'], 500);
        }
    }

    //APPROVE APPLICATION

    public function approveApplication($id)
    {
        $application = Careers::find($id);
        if (!$application) {
            return response()->json(['error' => 'Application not found.'], 404);
        }

        $application->status = 'approved';
        $application->save();

        return response()->json(['message' => 'Application approved successfully.', 'data' => $application]);
    }


    //REJECT APPLICATIOM

    public function rejectApplication($id)
    {
        $application = Careers::find($id);
        if (!$application) {
            return response()->json(['error' => 'Application not found.'], 404);
        }

        $application->status = 'rejected';
        $application->save();

        return response()->json(['message' => 'Application rejected successfully.', 'data' => $application]);
    }

    //UNDO APPLICATION STATUS
    public function undoApplicationStatus($id)
    {
    try {
        $application = Careers::find($id);
        if (!$application) {
            return response()->json(['error' => 'Application not found.'], 404);
        }

        $application->status = 'pending'; // Set status back to 'pending'
        $application->save();

        return response()->json(['message' => 'Application status undone successfully.', 'data' => $application]);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Unable to undo application status.'], 500);
    }
}

}
