<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitante extends Model
{
    use HasFactory;

    protected $fillable = [
        'documento_visitante',
        'nombre_visitante',
        'apellido_visitante',
        'id_tipo_visitante',
    ];
}
