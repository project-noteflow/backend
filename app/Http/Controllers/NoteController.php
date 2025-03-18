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


    public function updateNote(Request $request, $id_note)
    {
        $request->validate([
            'titulo' => 'sometimes|string|max:45',
            'contenido' => 'nullable|string',
            'eliminada' => 'nullable|boolean',
        ]);

        $note = Note::find($id_note);

        if (!$note) {
            return response()->json([
                'message' => 'Nota no encontrada'
            ], 404);
        }

        if ($request->has('titulo')) {
            $note->titulo = $request->titulo;
        }
        if ($request->has('contenido')) {
            $note->contenido = $request->contenido;
        }

        $note->fecha_actualizacion = now();
        $note->save();

        return response()->json([
            'message' => 'Nota actualizada exitosamente',
            'note' => $note
        ], 200);
    }
}
