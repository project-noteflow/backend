<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$allowedRoles)
    {
        $user = Auth::user();

        if (!$user || !in_array($user->id_rol, $allowedRoles)) {
            return response()->json([
                __('messages.labels.message') => __('auth.unauthorized')
            ], 401);
        }

        return $next($request);
    }
}
