<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Space extends Model
{
    protected $table = "espacios";
    protected $primaryKey = "id_espacio";
    public $timestamps = true;
    
    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';

    protected $fillable = ['id_usuario', 'id_tipo','nombre', 'descripcion', 'activo'];

    protected $casts = [
        'fecha_creacion' => 'date',
        'fecha_actualizacion' => 'date',
    ];
}
