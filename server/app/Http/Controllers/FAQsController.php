<?php
namespace App\Http\Controllers;

use App\Models\Faqs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class FaqsController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/faqs",
     *     summary="Retrieve a list of FAQs",
     *     tags={"FAQs"},
     *     @OA\Response(response="200", description="A list of FAQs"),
     *     @OA\Response(response="500", description="Server error")
     * )
     */
    public function getFaqs()
    {
        try {
            $faqs = Faqs::select('id', 'user_id', 'question', 'answer')
                ->get();
    
            return response()->json($faqs, 200);
        } catch (\Exception $e) {
            Log::error('Error in FaqsController@getFaqs: ' . $e->getMessage());
            return response()->json(['error' => 'Server Error'], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/faqs",
     *     summary="Create a new FAQ",
     *     tags={"FAQs"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="user_id", type="integer", description="ID of the user", example="1"),
     *             @OA\Property(property="question", type="string", description="FAQ question", example="What is the return policy?"),
     *             @OA\Property(property="answer", type="string", description="FAQ answer", example="Our return policy is 30 days.")
     *         )
     *     ),
     *     @OA\Response(response="201", description="FAQ created successfully"),
     *     @OA\Response(response="422", description="Validation errors"),
     *     @OA\Response(response="500", description="Server error")
     * )
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'nullable|integer',
                'question' => 'required|string',
                'answer' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $faq = new Faqs();
            $faq->user_id = $request->user_id ?: Auth::id(); // Use logged-in user ID if not provided
            $faq->question = $request->question;
            $faq->answer = $request->answer;
            $faq->save();

            return response()->json($faq, 201);
        } catch (\Exception $e) {
            Log::error('Error in FaqsController@store: ' . $e->getMessage());
            return response()->json(['error' => 'Server Error'], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/faqs/{id}",
     *     summary="Update an existing FAQ",
     *     tags={"FAQs"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the FAQ to update",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="answer", type="string", description="Updated answer for the FAQ", example="Our return policy is 30 days.")
     *         )
     *     ),
     *     @OA\Response(response="200", description="FAQ updated successfully"),
     *     @OA\Response(response="422", description="Validation errors"),
     *     @OA\Response(response="500", description="Server error")
     * )
     */
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'answer' => 'required|string', // Ensure 'answer' is required for update
            ]);
    
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
    
            $faq = Faqs::findOrFail($id);
            $faq->answer = $request->answer;
            $faq->save();
    
            return response()->json($faq, 200);
        } catch (\Exception $e) {
            Log::error('Error in FaqsController@update: ' . $e->getMessage());
            return response()->json(['error' => 'Server Error'], 500);
        }
    }
}
?>
