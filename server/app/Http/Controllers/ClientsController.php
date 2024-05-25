<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;

class ClientsController extends Controller
{
    public function index()
    {
        return response()->json(Users::all());
    }

    public function destroy($id)
    {
        $user = Users::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }

    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'phone' => 'required|string|max:255',
            'password' => 'sometimes|required|string|min:8',
        ]);

        // Find the user by ID
        $user = Users::findOrFail($id);

        // Update the user data, hashing the password if it's present
        if ($request->has('password')) {
            $validatedData['password'] = bcrypt($request->input('password'));
        }

        // Update the user data
        $user->update($validatedData);

        // Return the updated user data in the response
        return response()->json([
            'message' => 'User updated successfully',
            'user' => $user,
        ]);
    }
}
?>
