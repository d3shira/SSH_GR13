<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faqs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class FAQsController extends Controller
{
    public function store(Request $request)
    {
        Log::info('store method called'); // Log statement

        $request->validate([
            'question' => 'required|string|max:255',
        ]);

        $faq = Faqs::create([
            'user_id' => Auth::id(),
            'question' => $request->question,
            'answer' => null,
        ]);

        Log::info('FAQ created', ['faq' => $faq]); // Log statement

        return response()->json(['message' => 'Question submitted successfully', 'faq' => $faq], 201);
    }
}
