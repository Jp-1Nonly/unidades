<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Residente extends Model
{
    use HasFactory;

    protected $fillable = [
        'documento',
        'nombre',
        'apellido',
        'edad',
        'correo',
        'telefono',
        'apartamento',
        'mascota',
        'condicion',
        'discapacidad',
    ];
}
