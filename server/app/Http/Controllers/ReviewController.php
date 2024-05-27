<?php
namespace App\Http\Controllers;

use App\Models\Reviews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth; // Add this line

class ReviewController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/reviews",
     *     summary="Submit a review for a property",
     *     @OA\Parameter(
     *         name="user_id",
     *         in="query",
     *         description="ID of the user submitting the review (optional)",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="property_id",
     *         in="query",
     *         description="ID of the property being reviewed",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="review_category_id",
     *         in="query",
     *         description="ID of the review category (optional)",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="rating",
     *         in="query",
     *         description="Rating for the property (1 to 5)",
     *         required=true,
     *         @OA\Schema(type="integer", minimum=1, maximum=5)
     *     ),
     *     @OA\Parameter(
     *         name="comment",
     *         in="query",
     *         description="Comment for the review",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="201", description="Review submitted successfully"),
     *     @OA\Response(response="422", description="Validation errors"),
     *     @OA\Response(response="500", description="Server error")
     * )
     */
    public function store(Request $request)
    {
        try {
            $defaultReviewCategoryId = 1; // Set your default review category ID here
            
            $validator = Validator::make($request->all(), [
                'user_id' => 'nullable|integer',
                'property_id' => 'required|integer',
                'review_category_id' => 'nullable|integer',
                'rating' => 'required|integer|min:1|max:5', 
                'comment' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $review = new Reviews();
            $review->user_id = $request->user_id ?: Auth::id(); // Use logged-in user ID if not provided
            $review->property_id = $request->property_id;
            $review->review_category_id = $request->review_category_id ?: $defaultReviewCategoryId; // Use default or provided value
            $review->rating = $request->rating;
            $review->comment = $request->comment;
            $review->save();

            return response()->json($review, 201);
        } catch (\Exception $e) {
           Log::error('Error in ReviewController@store: ' . $e->getMessage());
           return response()->json(['error' => 'Server Error'], 500);
        }
    }
}
