<?php

namespace App\Http\Controllers;

use App\Models\Space;
use App\Services\ValidationService;
use App\Traits\ValidateSpaceRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SpaceController extends Controller
{
    use ValidateSpaceRequests;

    public function __construct(ValidationService $validationService)
    {
        $this->setValidationService($validationService);
    }

    public function create(Request $request)
    {
        if ($errorResponse = $this->validateCreate($request)) {
            return $errorResponse;
        }

        $countSpaces = Space::where('id_usuario', Auth::user()->id_usuario)->count('id_espacio');

        if ($countSpaces >= 5) {
            return response()->json([
                __('messages.labels.error') => __('messages.space.limit')
            ], 400);
        }

        $space = Space::create([
            'id_usuario' => Auth::user()->id_usuario,
            'id_tipo' => $request->input('id_tipo'),
            'nombre' => $request->input('nombre'),
            'descripcion' => $request->input('descripcion'),
        ]);

        return response()->json([
            __('messages.labels.message') => __('messages.space.created')
        ], 201);
    }

    public function update(Request $request)
    {
        if ($errorResponse = $this->validateUpdate($request)) {
            return $errorResponse;
        }

        $space = Space::where('id_usuario', Auth::user()->id_usuario)->where('id_espacio', $request->id_espacio)->first();

        $data = array_filter($request->only(['nombre', 'descripcion']), fn($value) => !is_null($value) && $value !== '');

        if (empty($data)) {
            return response()->json([
                __('messages.labels.message') => __('messages.space.empty'),
            ], 200);
        }
        
        $space->update($data);
        
        return response()->json([
            __('messages.labels.message') => __('messages.space.updated'),
        ], 200);
    }
}
