<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $table = 'notas'; 

    protected $primaryKey = 'id_nota';

    protected $fillable = [
        'id_espacio',
        'titulo',
        'contenido',
        'fecha_creacion',
        'fecha_actualizacion',
        'eliminada'
    ];

    public $timestamps = false; 

    public function space()
    {
        return $this->belongsTo(Space::class, 'id_espacio');
    }
}
