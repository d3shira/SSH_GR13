<?php
namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AgentController extends Controller
{
    public function getAgents(Request $request)
    {
        try {
            $agents = Users::select(
                'users.id',
                'users.first_name', 
                'users.last_name', 
                'users.email', 
                'users.phone', 
                'users.username',
                'sales_agents.job_position'
                )
                ->join('sales_agents', 'users.id', '=', 'sales_agents.user_id')
                ->get();

            return response()->json($agents);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to fetch agents.'], 500);
        }
    }

    public function editAgent(Request $request, $id)
    {
        try {
            // Retrieve the user by ID
            $user = Users::findOrFail($id);

            // Update user details
            $user->update([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'username' => $request->input('username'),
            ]);

            // If the user has a sales agent record, update job position
            if ($user->salesAgent) {
                $user->salesAgent->update([
                    'job_position' => $request->input('job_position')
                ]);
            }

            return response()->json(['message' => 'User updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to update user.'], 500);
        }
    }

    public function deleteAgent($id)
    {
        try {
            // Find the user by ID
            $user = Users::findOrFail($id);
            
            // Delete the user
            $user->delete();
            
            return response()->json(['message' => 'User deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to delete user.'], 500);
        }
    }
}

