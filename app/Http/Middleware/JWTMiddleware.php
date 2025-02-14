<?php

namespace App\Http\Middleware;

use App\Services\TokenService;
use Illuminate\Http\Request;
use Closure;

class JWTMiddleware
{
    private $tokenService;

    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    public function handle(Request $request, Closure $next)
    {
        $token = $request->cookie('access_token');
        
        $authResult = $this->tokenService->authenticateUser($token);

        if (is_array($authResult) && isset($authResult['error'])) {
            return response()->json([__('messages.labels.error') => $authResult['error']], 401);
        }

        return $next($request);
    }
}
