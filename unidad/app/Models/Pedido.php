<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'pedidos';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'proveedor_id',
        'estado',
        'observaciones',
        'total',
    ];

    // Relaciones (si aplican)
 
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'profesor_id');
    }

}
