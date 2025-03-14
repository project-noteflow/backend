<?php

namespace App\Http\Controllers;

use App\Enums\State;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\ValidationService;
use App\Traits\ValidateUserRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    use ValidateUserRequests;

    public function __construct(ValidationService $validationService)
    {
        $this->setValidationService($validationService);
    }

    public function getByToken()
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json([
                __('messages.labels.message') => __('messages.user.not_found')
            ], 404);
        }

        return response()->json([
            'data' => new UserResource($user),
        ]);
    }

    public function updateByToken(Request $request)
    {
        if ($errorResponse = $this->validateUpdateUser($request)) {
            return $errorResponse;
        }

        $user = Auth::user();

        $data = array_filter($request->only(['nombre', 'correo', 'clave']), fn($value) => !is_null($value) && $value !== '');

        if (!empty($data)) {
            $user->save($data);
        }

        return response()->json([
            __('messages.labels.message') => __('messages.user.updated'),
        ], 200);
    }

    public function deactiveOwnAccount()
    {
        $user = Auth::user();

        $user->activo = State::deactive->value;
        $user->save();

        Auth::logout();
        
        return response()->json([
            __('messages.labels.message') => __('messages.user.deactived'),
        ], 200);
    }
}
