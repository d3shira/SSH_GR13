<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;

class CheckAbility
{
    public function handle(Request $request, Closure $next, $role, $ability = null)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        if (!$user || !$user->hasRole($role)) {
            return response()->json(['error' => 'Forbidden. You do not have the required role.'], 403);
        }

        if ($ability && !$user->hasAbility($ability)) {
            return response()->json(['error' => 'Forbidden. You do not have the required ability.'], 403);
        }

        return $next($request);
    }
}