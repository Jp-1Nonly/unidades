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

    // Relaciones

    // Relación con el modelo Proveedor
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedor_id'); // Asegúrate de que la clave foránea sea correcta
    }

    // Relación con el modelo DetallePedido
    public function detalles()
    {
        return $this->hasMany(DetallePedido::class, 'pedido_id'); // Ajusta según la clave foránea en la tabla detallepedidos
    }
}
