<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visita extends Model
{
    use HasFactory;

 
    protected $fillable = [
        'visitante_id',
        'residente_id',
        'fecha_ingreso',
        'fecha_salida',
        'motivo_visita',
        'vehiculo',
    ];
}