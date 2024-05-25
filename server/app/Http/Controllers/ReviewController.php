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
            $review->user_id = $request->user_id;
            $review->property_id = $request->property_id;
            $review->review_category_id = $defaultReviewCategoryId; // Use default or fetched value
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