<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    protected $fillable = [
        'documento',
        'nombre_persona',
        'apellido',
        'correo',
        'telefono',
        'fecha_contratacion',
        'cargo_id',
        'departamento_id',
    ];
}
