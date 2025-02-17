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
}
