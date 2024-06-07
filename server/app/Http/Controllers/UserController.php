<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users; 
use App\Models\SalesAgents;
use App\Models\Ability;
use App\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/registerAdmin",
     *     summary="Register a new admin",
     *     tags={"User Controller"},
     *     @OA\Parameter(
     *         name="first_name",
     *         in="query",
     *         description="Admin's first name",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="last_name",
     *         in="query",
     *         description="Admin's last name",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="username",
     *         in="query",
     *         description="Admin's username",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="Admin's email",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="phone",
     *         in="query",
     *         description="Admin's phone",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="Admin's password",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="201", description="User registered as admin successfully"),
     *     @OA\Response(response="422", description="Validation errors")
     * )
     */
    public function registerAdmin(Request $request)
    {
        // Validation rules for registering an admin
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users', 
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:255',
            'password' => 'required|string|min:8',
        ]);

        $hashedPassword = Hash::make($request->password);

        $user = new Users();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = $hashedPassword;

        // Get the admin role
        $adminRole = Role::where('role_name', 'admin')->first();

        if (!$adminRole) {
            // If admin role not found, return error response
            return response()->json(['error' => 'Admin role not found'], 404);
        }

        // Associate the admin role with the user
        $user->role_id = $adminRole->id;
        $user->save();

        return response()->json([
            'message' => 'User registered as admin successfully',
            'user' => [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'username' => $user->username,
                'email' => $user->email,
                'phone' => $user->phone,
                'role' => [
                    'id' => $user->role->id,
                    'role_name' => $user->role->role_name,
                ],
            ]
        ], 201);
    }

    /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="Register a new user",
     *     tags={"User Controller"},
     *     @OA\Parameter(
     *         name="first_name",
     *         in="query",
     *         description="User's first name",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="last_name",
     *         in="query",
     *         description="User's last name",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="username",
     *         in="query",
     *         description="User's username",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="User's email",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="phone",
     *         in="query",
     *         description="User's phone",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="User's password",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="201", description="User registered successfully"),
     *     @OA\Response(response="422", description="Validation errors")
     * )
     */
    public function register(Request $request) //register for normal users
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
        $user->phone = $request->phone;
        $user->password = $hashedPassword; 
        
        $clientRole = Role::where('role_name', 'client')->first();

        if (!$clientRole) {
            return response()->json(['error' => 'Client role not found'], 404);
        }

        $user->role_id = $clientRole->id;
        $user->save();

        return response()->json(['message' => 'User registered successfully', 'data' => $user], 201);
    }

    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="User login",
     *     tags={"User Controller"},
     *     @OA\Parameter(
     *         name="username",
     *         in="query",
     *         description="User's username",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="User's password",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="User logged in successfully"),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="422", description="Validation errors")
     * )
     */
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

        $redirectPath = '/';
        if ($user->role_id === 1) { // Assuming admin role ID is 13
            $redirectPath = '/admindashboard';
        } elseif ($user->role_id === 3) { // Assuming staff role ID is 15
            $redirectPath = '/staffdashboard';
        }

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 3600,
            'user' => $user,
            'redirect' => $redirectPath // Return the redirect path
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/registerStaff",
     *     summary="Register a new staff",
     *     tags={"User Controller"},
     *     @OA\Parameter(
     *         name="first_name",
     *         in="query",
     *         description="Staff's first name",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="last_name",
     *         in="query",
     *         description="Staff's last name",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="username",
     *         in="query",
     *         description="Staff's username",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="Staff's email",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="phone",
     *         in="query",
     *         description="Staff's phone",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="job_position",
     *         in="query",
     *         description="Staff's job position",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="Staff's password",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="image",
     *         in="query",
     *         description="Staff's image",
     *         required=false,
     *         @OA\Schema(type="string", format="binary")
     *     ),
     *     @OA\Response(response="201", description="Staff registered successfully"),
     *     @OA\Response(response="422", description="Validation errors")
     * )
     */
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
        
        $staffRole = Role::where('role_name', 'staff')->first();

        if (!$staffRole) {
            return response()->json(['error' => 'Staff role not found'], 404);
        }

        // Associate the admin role with the user
        $user->role_id = $staffRole->id;
        $user->save();

        // Save sales agent
        $salesAgent = new SalesAgents();
        $salesAgent->user_id = $user->id;
        $salesAgent->job_position = $request->job_position;
        $salesAgent->image = asset($imagePath);
        $salesAgent->save();

        return response()->json(['message' => 'Staff registered successfully', 'data' => $user], 201);
    }

    /**
     * @OA\Post(
     *     path="/api/logout",
     *     summary="Logout user",
     *     tags={"User Controller"},
     *     @OA\Response(response="200", description="User successfully logged out"),
     *     @OA\Response(response="500", description="Sorry, the user cannot be logged out")
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/api/user",
     *     summary="Get authenticated user",
     *     tags={"User Controller"},
     *     @OA\Response(response="200", description="Authenticated user retrieved successfully"),
     *     @OA\Response(response="404", description="User not found"),
     *     @OA\Response(response="500", description="Could not authenticate token")
     * )
     */
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
}
