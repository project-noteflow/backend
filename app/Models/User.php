<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = "usuarios";
    protected $primaryKey = 'id_usuario';
    public $timestamps = true;

    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';

    protected $fillable = ['id_rol', 'nombre', 'correo', 'clave', 'activo'];

    protected $casts = [
        'fecha_creacion' => 'date',
        'fecha_actualizacion' => 'date',
    ];

    protected $hidden = ['clave'];

    public function setClaveAttribute($value)
    {
        $this->attributes['clave'] = bcrypt($value);
    }

    public function getAuthPassword()
    {
        return $this->clave;
    }
}
