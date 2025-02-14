<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\ValidationService;
use App\Traits\ValidateUserRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function Pest\Laravel\json;

class UserController extends Controller
{
    use ValidateUserRequests;

    public function __construct(ValidationService $validationService)
    {
        $this->setValidationService($validationService);
    }

    public function getAll()
    {
        $users = User::all();

        if ($users->isEmpty()) {
            return response()->json([
                __('messages.labels.message') => __('messages.users.not_found')
            ], 404);
        }

        return UserResource::collection($users);
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

    public function create(Request $request)
    {
        if ($errorResponse = $this->validateUser($request)) {
            return $errorResponse;
        }

        $user = User::create([
            'nombre' => $request->input('nombre'),
            'id_rol' => $request->input('rol'),
            'correo' => $request->input('correo'),
            'clave' => $request->input('clave')
        ]);

        return response()->json([
            __('messages.labels.message') => __('messages.user.created'),
            'data' => $user
        ], 201);
    }

    public function updateByToken(Request $request)
    {
        if ($errorResponse = $this->validateUpdateUser($request)) {
            return $errorResponse;
        }

        $user = Auth::user();

        $data = array_filter($request->only(['nombre', 'correo', 'clave']), fn($value) => !is_null($value) && $value !== '');

        if (!empty($data)) {
            $user->update($data);
        }

        return response()->json([
            __('messages.labels.message') => __('messages.user.updated'),
        ], 200);
    }
}
