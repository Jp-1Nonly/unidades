<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePedido extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'detallepedidos';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'pedido_id',
        'producto_id',
        'medida',
        'cantidad',
        'precio_unitario',
        'total',
    ];

    // Relaciones
    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'pedido_id');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}
