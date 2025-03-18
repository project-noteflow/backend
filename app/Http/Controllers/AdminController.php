<?php

namespace App\Http\Controllers;

use App\Enums\State;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\ValidationService;
use App\Traits\ValidateUserRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
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

    public function deactivateUser($id)
    {
        try {

            $user = User::findOrFail($id);

            Gate::authorize('deactivate', $user);

            $user->activo = State::deactive->value;
            $user->save();

            return response()->json([
                __('messages.labels.message') => __('messages.user.deactived'),
            ]);
        } catch (\Exception) {
            return response()->json([
                __('messages.labels.message') => __('messages.error.exception'),
            ], 403);
        }
    }

    public function activateUser($id)
    {
        try {

            $user = User::findOrFail($id);

            Gate::authorize('activate', $user);

            $user->activo = State::active->value;
            $user->save();

            return response()->json([
                __('messages.labels.message') => __('messages.user.actived'),
            ]);
        } catch (\Exception) {
            return response()->json([
                __('messages.labels.message') => __('messages.error.exception'),
            ], 403);
        }
    }
}
