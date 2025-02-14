<?php

namespace App\Traits;

use App\Services\ValidationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

trait ValidateUserRequests
{
    protected ValidationService $validationService;

    public function setValidationService(ValidationService $validationService)
    {
        $this->validationService = $validationService;
    }

    public function validateCreate(Request $request)
    {
        $rules = [
            'nombre' => 'required|string',
            'correo' => 'required|email|unique:usuarios,correo',
            'clave' => ['required', 'string', Password::min(8)->mixedCase()->numbers()->symbols()->uncompromised()]
        ];

        return $this->validationService->validate($request->all(), $rules);
    }

    public function validateUser(Request $request)
    {
        $rules = [
            'nombre' => 'required|string',
            'rol' => 'required|integer|exists:rol_usuario,id_rol',
            'correo' => 'required|email|unique:usuarios,correo',
            'clave' => ['required', 'string', Password::min(8)->mixedCase()->numbers()->symbols()->uncompromised()]
        ];

        return $this->validationService->validate($request->all(), $rules);
    }

    public function validateCredentials(Request $request)
    {
        $rules = [
            'correo' => 'required|email|exists:usuarios,correo',
            'password' => 'required|string|min:8'
        ];

        return $this->validationService->validate($request->all(), $rules);
    }

    public function validateUpdateUser(Request $request)
    {
        $rules = [
            'nombre' => 'sometimes|string',
            'correo' => 'sometimes|email|unique:usuarios,correo,' . Auth::user()->id_usuario . ',id_usuario',
            'password' => ['sometimes', Password::min(8)->mixedCase()->numbers()->symbols()->uncompromised()]
        ];

        return $this->validationService->validate($request->all(), $rules);
    }
}
