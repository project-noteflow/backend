<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = "rol_usuario";

    protected $primaryKey = "id_rol";

    protected $fillable = ['nombre'];
}
