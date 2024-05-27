<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;

class ClientsController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/clients",
     *     summary="Get all clients",
     *     @OA\Response(response="200", description="List of clients"),
     *     @OA\Response(response="500", description="Unable to fetch clients")
     * )
     */
    public function index()
    {
        return response()->json(Users::all());
    }

    /**
     * @OA\Delete(
     *     path="/api/clients/{id}",
     *     summary="Delete a client",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Client ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="User deleted successfully"),
     *     @OA\Response(response="404", description="User not found"),
     *     @OA\Response(response="500", description="Unable to delete user")
     * )
     */
    public function destroy($id)
    {
        try {
            $user = Users::findOrFail($id);
            $user->delete();
            return response()->json(['message' => 'User deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to delete user'], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/clients/{id}",
     *     summary="Update a client",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Client ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="first_name", type="string", description="First name"),
     *             @OA\Property(property="last_name", type="string", description="Last name"),
     *             @OA\Property(property="username", type="string", description="Username"),
     *             @OA\Property(property="email", type="string", format="email", description="Email"),
     *             @OA\Property(property="phone", type="string", description="Phone number"),
     *             @OA\Property(property="password", type="string", description="Password", nullable=true)
     *         )
     *     ),
     *     @OA\Response(response="200", description="User updated successfully"),
     *     @OA\Response(response="422", description="Validation errors"),
     *     @OA\Response(response="404", description="User not found"),
     *     @OA\Response(response="500", description="Unable to update user")
     * )
     */
    public function update(Request $request, $id)
    {
        try {
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
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to update user'], 500);
        }
    }
}
?>

