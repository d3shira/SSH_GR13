<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users; 
use App\Models\SalesAgents;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Validation\ValidationException;


class UserController extends Controller
{
    public function register(Request $request)       //register for normal users
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users', 
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:255',
            'password' => 'required|string|min:8', 
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $hashedPassword = Hash::make($request->password);

        $user = new Users();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->phone= $request->phone;
        $user->password = $hashedPassword; 
        $user->role = 'client'; // Set role to client
        $user->save();

        return response()->json(['message' => 'User registered successfully', 'data' => $user], 201);
    }

    public function login(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string'
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
   // Retrieve the user by username
   $user = Users::where('username', $request->username)->first();

   if (!$user || !Hash::check($request->password, $user->password)) {
       return response()->json(['error' => 'Unauthorized'], 401);
   }

   // Generate token
   if (!$token = JWTAuth::fromUser($user)) {
       return response()->json(['error' => 'Could not create token'], 500);
   }

   // Determine the redirect path based on the user's role
   $redirectPath = $user->role === 'staff' ? '/staffDashboard' : '/';

   return response()->json([
       'access_token' => $token,
       'token_type' => 'bearer',
       'expires_in' => JWTAuth::factory()->getTTL() * 3600,
       'user' => $user,
       'redirect' => $redirectPath // Return the redirect path
   ]);

   return $this->createNewToken($token);
            
 } 
    
    
  public function registerStaff(Request $request)
    {
        // Validation rules for staff registration
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users', 
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:255',
            'job_position' => 'required|string|max:255',
            'password' => 'required|string|min:8', 
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $hashedPassword = Hash::make($request->password);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('agents_picture'), $fileName);
            $imagePath = 'agents_picture/' . $fileName;
        } else {
            $imagePath = null; // Handle the case where the image is not provided
        }

        // Save staff
        $user = new Users();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = $hashedPassword; 
        $user->role = 'staff'; // Set role to staff
        $user->save();

        // Save sales agent
        $salesAgent = new SalesAgents();
        $salesAgent->user_id = $user->id;
        $salesAgent->job_position = $request->job_position;
        $salesAgent->image = asset($imagePath);
        $salesAgent->save();

        return response()->json(['message' => 'Staff registered successfully', 'data' => $user], 201);
    }

    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 3600,
            'user' => auth()->user()
        ]);
    }

    public function getAuthenticatedUser()
    {
        try {
            // Attempt to authenticate the user with the provided token
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                // Return a 404 response if the user is not found
                return response()->json(['user_not_found'], 404);
            }
        } catch (JWTException $e) {
            // Return a 500 response if there is an error during token authentication
            return response()->json(['error' => 'Could not authenticate token'], 500);
        }

        // Return the authenticated user
        return response()->json($user);
    }


    public function logout()
{
    try {
        // Invalidate the token
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['message' => 'User successfully logged out']);
    } catch (JWTException $exception) {
        return response()->json(['error' => 'Sorry, the user cannot be logged out'], 500);
    }
}


}



