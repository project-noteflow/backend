<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;


class NoteController extends Controller
{

   public function getAllNotes($id_espacio)
{
    $notes = Note::where('id_espacio', $id_espacio)->get();

    return response()->json([
        'notes' => $notes
    ], 200);
}

    public function createNote(Request $request)
{
    $request->validate([
        'id_espacio' => 'required|integer|exists:espacios,id_espacio',
        'titulo' => 'required|string|max:45',
        'contenido' => 'nullable|string',
    ]);

    $cantidadNotas = Note::where('id_espacio', $request->id_espacio)->count();

    if ($cantidadNotas >= 5) {
        return response()->json([
            'message' => 'No se pueden crear más de 5 notas en este espacio'
        ], 400);
    }

    $note = Note::create([
        'id_espacio' => $request->id_espacio,
        'titulo' => $request->titulo,
        'contenido' => $request->contenido,
        'fecha_creacion' => now(),
        'fecha_actualizacion' => now(),
        'eliminada' => 1
    ]);

    return response()->json([
        'message' => 'Nota creada exitosamente',
        'note' => $note
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
