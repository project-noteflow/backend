<?php

namespace App\Http\Controllers;

use App\Traits\ValidateUserRequests;
use App\Services\ValidationService;
use App\Services\JWTService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Enums\TypeUser;
use App\Helpers\CookieHelper;

class AuthController extends Controller
{
    use ValidateUserRequests;

    private $jwtService;

    public function __construct(ValidationService $validationService, JWTService $jwtService)
    {
        $this->jwtService = $jwtService;
        $this->setValidationService($validationService);
    }

    public function register(Request $request)
    {
        if ($errorResponse = $this->validateCreate($request)) {
            return $errorResponse;
        }

        $user = User::create([
            'nombre' => $request->input('nombre'),
            'id_rol' => TypeUser::User,
            'correo' => $request->input('correo'),
            'clave' => $request->input('clave')
        ]);

        return response()->json([
            __('messages.message') => __('messages.user.created'),
        ], 201);
    }

    public function login(Request $request)
    {
        if ($errorResponse = $this->validateCredentials($request)) {
            return $errorResponse;
        }

        $credentials = $request->only('correo', 'password');

        if (!Auth::attempt($credentials) || !Auth::user()->activo) {
            return response()->json([__('messages.labels.error') => __('auth.credentials.invalid')], 401);
        }

        $user = Auth::user();

        $accessToken = $this->jwtService->generateToken(['sub' => $user->id_usuario], 900);
        $refreshToken = $this->jwtService->generateToken(['sub' => $user->id_usuario], 604800);

        return response()->json([
            __('messages.labels.message') => __('auth.auth.success'),
            __('auth.auth.access_token') => $accessToken,
        ])->cookie(CookieHelper::createHttpOnlyCookie('access_token', $accessToken, 900))
            ->cookie(CookieHelper::createHttpOnlyCookie('refresh_token', $refreshToken, 900));
    }

    // public function refresh(Request $request)
    // {
    //     $refreshToken = $request->cookie('refresh_token');

    //     $decoded = $this->jwtService->verifyToken($refreshToken);

    //     if (!$refreshToken || !$decoded) {
    //         return response()->json([
    //             __('message.message') => __('auth.refresh_token_invalid')
    //         ], 401);
    //     }

    //     $userId = $decoded->sub;

    //     if (!RefreshToken::where('user_id', $userId)->where('token', $refreshToken)->exists()) {
    //         return response()->json(['message' => 'Refresh Token inválido'], 401);
    //     }

    //     $newAccessToken = $this->jwtService->generateToken(['sub' => $userId], 900);

    //     return response()->json([
    //         __('messages.message') => __('auth.refresh_token_success'),
    //     ])
    //         ->cookie(CookieHelper::createHttpOnlyCookie('access_token', $newAccessToken, 900));
    // }
}
