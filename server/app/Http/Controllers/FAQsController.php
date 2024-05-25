<?php
namespace App\Http\Controllers;

use App\Models\Faqs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth; // Add this line

class FaqsController extends Controller
{
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
            $faq->user_id = $request->user_id;
            $faq->question = $request->question;
            $faq->answer = $request->answer;
            $faq->save();

            return response()->json($faq, 201);
        } catch (\Exception $e) {
           Log::error('Error in FaqsController@store: ' . $e->getMessage());
           return response()->json(['error' => 'Server Error'], 500);
        }
    }
}
