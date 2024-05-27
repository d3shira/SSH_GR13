<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Careers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class CareersController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/careers",
     *     summary="Submit a job application",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(property="name", type="string", description="Applicant's name"),
     *                 @OA\Property(property="surname", type="string", description="Applicant's surname"),
     *                 @OA\Property(property="birthday", type="string", format="date", description="Applicant's birthday"),
     *                 @OA\Property(property="nationality", type="string", description="Applicant's nationality"),
     *                 @OA\Property(property="personal_number", type="string", description="Applicant's personal number"),
     *                 @OA\Property(property="email", type="string", format="email", description="Applicant's email"),
     *                 @OA\Property(property="message", type="string", description="Applicant's message"),
     *                 @OA\Property(property="resume", type="string", format="binary", description="Applicant's resume"),
     *             )
     *         )
     *     ),
     *     @OA\Response(response="201", description="Form submitted successfully"),
     *     @OA\Response(response="422", description="Validation errors")
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/api/job-applications",
     *     summary="Get all job applications",
     *     @OA\Response(response="200", description="List of job applications"),
     *     @OA\Response(response="500", description="Unable to fetch job applications")
     * )
     */
    public function getJobApplications()
    {
        try {
            $jobApplications = Careers::all();
            return response()->json($jobApplications);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to fetch job applications.'], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/job-applications/{id}/approve",
     *     summary="Approve a job application",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Job application ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Application approved successfully"),
     *     @OA\Response(response="404", description="Application not found")
     * )
     */
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

    /**
     * @OA\Post(
     *     path="/api/job-applications/{id}/reject",
     *     summary="Reject a job application",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Job application ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Application rejected successfully"),
     *     @OA\Response(response="404", description="Application not found")
     * )
     */
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

    /**
     * @OA\Post(
     *     path="/api/job-applications/{id}/undo",
     *     summary="Undo job application status",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Job application ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Application status undone successfully"),
     *     @OA\Response(response="404", description="Application not found"),
     *     @OA\Response(response="500", description="Unable to undo application status")
     * )
     */
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
?>

