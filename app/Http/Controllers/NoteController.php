<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;
use App\Models\Space;
use App\Services\ValidationService;
use App\Traits\ValidateNoteRequest;

class NoteController extends Controller
{
    use ValidateNoteRequest;

    public function __construct(ValidationService $validationService)
    {
        $this->setValidationService($validationService);
    }

    public function getAllNotes($id_espacio)
    {
        $notes = Note::where('id_espacio', $id_espacio)->get();

        return response()->json([
            'notes' => $notes
        ], 200);
    }

    public function createNote(Request $request)
    {
        if ($errorResponse = $this->validateCreate($request)) {
            return $errorResponse;
        }

        $notes = Note::where('id_espacio', $request->id_espacio)->count();

        if ($notes >= 5) {
            return response()->json([
                __('messages.labels.error') => __('messages.note.limit')
            ], 400);
        }

        $note = Note::create([
            'id_espacio' => $request->id_espacio,
            'titulo' => $request->titulo,
            'contenido' => $request->contenido,
            'fecha_creacion' => now(),
            'fecha_actualizacion' => now()
        ]);

        return response()->json([
            __('messages.labels.message') => __('messages.note.created'),
        ], 201);
    }


    public function updateNote(Request $request, $id)
    {
        if ($errorResponse = $this->validateUpdate($request)) {
            return $errorResponse;
        }

        $note = Note::find($id);

        if (!$note) {
            return response()->json([
                __('messages.labels.error') => __('messages.note.not_found'),
            ], 404);
        }

        $data = array_filter($request->only(['titulo', 'contenido']), fn($value) => !is_null($value) && $value !== '');

        if (empty($data)) {
            return response()->json([
                __('messages.labels.message') => __('messages.note.empty'),
            ], 200);
        }

        $note->titulo = isset($request->titulo) ? $request->titulo : $note->titulo;
        $note->contenido = isset($request->contenido) ? $request->contenido : $note->contenido;
        $note->fecha_actualizacion = now();
        $note->save();

        return response()->json([
            __('messages.labels.message') => __('messages.note.updated')
        ], 200);
    }
}
