<?php

namespace App\Traits;

use App\Services\ValidationService;
use Illuminate\Http\Request;

trait ValidateNoteRequest
{
    protected ValidationService $validationService;

    public function setValidationService(ValidationService $validationService)
    {
        $this->validationService = $validationService;
    }

    public function validateCreate(Request $request)
    {
        $rules = [
            'id_espacio' => 'required|integer|exists:espacios,id_espacio',
            'titulo' => 'required|string|max:45',
            'contenido' => 'nullable|string',
        ];

        return $this->validationService->validate($request->all(), $rules);
    }
}
