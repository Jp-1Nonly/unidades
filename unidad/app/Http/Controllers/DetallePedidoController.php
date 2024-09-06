<?php

namespace App\Http\Controllers;
use App\Models\Area;
use App\Models\DetallePedido;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class DetallePedidoController extends Controller
{
    public function mostrarFormularioSaldo()
    {
        $areas = Area::all();
        return view('productos.saldoarea', compact('areas'));
    }

    public function calcularSaldoArea(Request $request)
    {
        // Obtener el area_id del request
        $productos = Producto::all();
        $area = Area::all();

        $areaId = $request->input('area_id');
        
        // Sumar los valores del campo especificado en la tabla detalle_pedidos filtrados por area_id
        $saldoAreaDetalle = DB::table('detallepedidos')
            ->where('area_id', $areaId)
            ->sum('total'); 

        // Obtener el área correspondiente y calcular el saldo basado en asignado, adicion y consumo
        $area = DB::table('areas')->where('id', $areaId)->first();

        if ($area) {
            $saldoArea = ($area->asignado + $area->adicion) - $saldoAreaDetalle;
            $nombreArea = $area->nombre;
        } else {
            $saldoArea = 0; // Manejo de error si el área no se encuentra
            $nombreArea = 'Área no encontrada';
        }

        // Enviar el resultado a la vista productos.listaproductos
        return view('productos.listaproductos', compact('saldoAreaDetalle', 'saldoArea', 'nombreArea','productos', 'area_id'));
    }

    public function delete($id)
    {
      
        $detalle = DetallePedido::find($id);
        $detalle->delete();

        return redirect()->back()->with('success', 'Producto eliminado con éxito.');
   
    }
}
