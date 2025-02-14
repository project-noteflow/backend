<?php

namespace App\Services;

use App\Models\User;
use App\Services\JWTService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TokenService
{
    protected $jwtService;

    public function __construct(JWTService $jwtService)
    {
        $this->jwtService = $jwtService;
    }

    public function authenticateUser($token)
    {
        if (!$token) {
            return [__('messages.labels.error') => __('auth.token.not_provided')];
        }
        try {
            $decoded = $this->jwtService->verifyToken($token);

            if (is_array($decoded)) {
                return $decoded;
            }

            $user = User::find($decoded->sub);

            if (!$user) {
                return [__('messages.labels.error') => __('auth.token.not_provided')];
            }

            Auth::login($user);

            return $user;
        } catch (\Exception $e) {
            return [__('messages.labels.error') => __('auth.token.not_provided')];
        }
    }
}
