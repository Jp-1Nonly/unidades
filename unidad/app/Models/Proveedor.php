<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'proveedores';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'documento',
        'nombre',
        'celular',
        'correo',
    ];
}
