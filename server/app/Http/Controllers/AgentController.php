<?php
namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AgentController extends Controller
{
    
    /**
     * @OA\Get(
     *     path="/api/agents",
     *     summary="Get all agents",
     *     tags={"Agents"},
     *     @OA\Response(response="200", description="List of agents"),
     *     @OA\Response(response="500", description="Unable to fetch agents")
     * )
     */
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
                'sales_agents.job_position',
                'sales_agents.image'
                )
                ->join('sales_agents', 'users.id', '=', 'sales_agents.user_id')
                ->get();

            return response()->json($agents);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to fetch agents.'], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/agents/{id}",
     *     summary="Edit an agent",
     *     tags={"Agents"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Agent ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="first_name",
     *         in="query",
     *         description="First name of the agent",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="last_name",
     *         in="query",
     *         description="Last name of the agent",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="Email of the agent",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="phone",
     *         in="query",
     *         description="Phone number of the agent",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="username",
     *         in="query",
     *         description="Username of the agent",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="job_position",
     *         in="query",
     *         description="Job position of the agent",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="image",
     *         in="query",
     *         description="Image path of the agent",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="User updated successfully"),
     *     @OA\Response(response="500", description="Unable to update user")
     * )
     */
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

            // If the user has a sales agent record, update job position and image path
            if ($user->salesAgent) {
                $salesAgent = $user->salesAgent;
                $salesAgent->job_position = $request->input('job_position');
                $salesAgent->image = $request->input('image');

                $salesAgent->save();
            }

            return response()->json(['message' => 'User updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to update user.'], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/agents/upload-image",
     *     summary="Upload an agent image",
     *     tags={"Agents"},
     *     @OA\RequestBody(
     *         description="Image file to upload",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="image",
     *                     description="Image file",
     *                     type="string",
     *                     format="binary"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="Image uploaded successfully"),
     *     @OA\Response(response="400", description="No file uploaded"),
     *     @OA\Response(response="500", description="Unable to upload image")
     * )
     */
    public function uploadAgentImage(Request $request)
    {
        try {
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('agents_picture'), $fileName);
                $imagePath = 'agents_picture/' . $fileName;

                return response()->json(['imagePath' => asset($imagePath)]);
            } else {
                return response()->json(['error' => 'No file uploaded.'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to upload image.'], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/agents/{id}",
     *     summary="Delete an agent",
     *     tags={"Agents"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Agent ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="User deleted successfully"),
     *     @OA\Response(response="500", description="Unable to delete user")
     * )
     */
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
?>
