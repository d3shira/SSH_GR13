<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Applications;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/contact",
     *     summary="Submit a contact application",
     *     tags={"Contact Us"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", description="Applicant's name", example="John Doe"),
     *             @OA\Property(property="address", type="string", description="Applicant's address", example="123 Main St"),
     *             @OA\Property(property="contact", type="string", description="Applicant's contact", example="123-456-7890"),
     *             @OA\Property(property="email", type="string", format="email", description="Applicant's email", example="john.doe@example.com"),
     *             @OA\Property(property="message", type="string", description="Applicant's message", example="I am interested in your services.")
     *         )
     *     ),
     *     @OA\Response(response="201", description="Application submitted successfully"),
     *     @OA\Response(response="422", description="Validation errors")
     * )
     */
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
?>
