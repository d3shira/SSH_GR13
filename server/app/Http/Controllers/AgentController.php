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
                'users.first_name', 
                'users.last_name', 
                'users.email', 
                'users.phone', 
                'sales_agents.job_position'
                )
                ->join('sales_agents', 'users.id', '=', 'sales_agents.user_id')
                ->get();

            return response()->json($agents);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to fetch agents.'], 500);
        }
    }
}

