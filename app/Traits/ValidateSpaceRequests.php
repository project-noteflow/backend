<?php

namespace App\Traits;

use App\Services\ValidationService;
use Illuminate\Http\Request;

trait ValidateSpaceRequests
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
            'descripcion' => 'required|string',
            'id_tipo' => 'required|integer|exists:tipos_espacios,id_tipo'
        ];

        return $this->validationService->validate($request->all(), $rules);
    }

    public function validateUpdate(Request $request)
    {
        $rules = [
            'id_espacio' => 'required|integer|exists:espacios,id_espacio',
            'nombre' => 'sometimes|string:min:6',
            'descripcion' => 'sometimes|string|min:8',
        ];

        return $this->validationService->validate($request->all(), $rules);
    }
}
