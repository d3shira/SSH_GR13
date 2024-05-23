<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function register(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users', // Assuming unique username
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8', // Minimum 8 characters for password
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Hash the password with a salt
        $hashedPassword = Hash::make($request->password);

        $user = new Users();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = $hashedPassword; // Store the hashed password
        $user->save();

        return response()->json(['message' => 'User registered successfully', 'data' => $user], 201);
    }
}