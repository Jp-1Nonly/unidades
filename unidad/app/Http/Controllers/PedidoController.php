<?php

namespace App\Http\Controllers;


use App\Models\Area;
use App\Models\Dato;
use App\Models\DetallePedidoFavorito;
use App\Models\PedidoFavorito;
use DataTables;
use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\DetallePedido;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Producto;
use App\Models\profesore;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PedidoExport;
use App\Models\Pago;
use App\Models\Proveedor;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;




class PedidoController extends Controller
{
   public function index()
    {
        $pedidos = Pedido::orderBy('created_at', 'desc')->get();
  

        // Consulta para obtener la suma del campo total por pedido_id
        $detalleSums = DB::table('detallepedidos')
                        ->select('pedido_id', DB::raw('SUM(total) AS suma_total'))
                        ->groupBy('pedido_id')
                        ->get();

        // Transformar los resultados en un array asociativo
        $sumaPorPedido = $detalleSums->pluck('suma_total', 'pedido_id');

        return view('pedidos.index', compact('pedidos', 'sumaPorPedido'));
    }

    public function show($id)
    {
        $datos = Dato::first();
        $pedido = Pedido::with(['detalles' => function ($query) {
            $query->orderBy('producto_id', 'asc');
        }])->findOrFail($id);

        // Ordenar los detalles del pedido por producto_id
        $pedido->detalles = $pedido->detalles->sortBy('producto_id');

        return view('pedidos.show', compact('datos', 'pedido'));
    }

    public function tabla($id)
    {
        $datos = Dato::first();
        $pedido = Pedido::with(['detalles' => function ($query) {
            $query->orderBy('producto_id', 'asc');
        }])->findOrFail($id);

        // Ordenar los detalles del pedido por producto_id
        $pedido->detalles = $pedido->detalles->sortBy('producto_id');

        return view('pedidos.excel', compact('datos', 'pedido'));
    }


    public function store(Request $request)
    {
        $request->validate([
            
            'profesor' => 'required',
            'observaciones' => 'required',
            
        ]);

        // Crea el pedido
        $pedido = new Pedido();
        $pedido->fill($request->all());
        $pedido->save();

        session()->forget('cart');
        return redirect()->route('pedidos.index')->with('success', 'Pedido realizado con éxito.');
    }


    // app/Http/Controllers/PedidoController.php

    public function generatePDF($id)
    {
        // Obtiene el pedido según el ID (usando Eloquent)
        $datos = Dato::first();
        $pedido = Pedido::with('detalles.producto')->findOrFail($id);

        // Carga la vista 'pedidos.pdf' con los datos del pedido
        $pdf = PDF::loadView('pedidos.pdf', compact('pedido', 'datos'));

        // Descarga el PDF con un nombre único basado en el ID del pedido
        return $pdf->download('pedido_' . $pedido->id . '.pdf');
    }


  public function edit($id)
{
   
    $proveedores = Proveedor::all();
    $pedido = Pedido::findOrFail($id);
    $pagos = Pago::all();
   
    
    // Si el pedido fue clonado, obten los detalles del pedido original
    if ($pedido->clonado_de) {
        $pedidoOriginal = Pedido::findOrFail($pedido->clonado_de);
        $detallesPedido = $pedidoOriginal->detalles()->get();
    } else {
        $detallesPedido = $pedido->detalles()->get();
    }

    return view('pedidos.editar', compact('pedido', 'detallesPedido', 'proveedores', 'pagos'));
}







public function update(Request $request, $id)
{
    
    $pedido = Pedido::findOrFail($id);
        
    $total_anterior = $pedido->total;
    
    
    $pedido->total = 0;

   

    $pedido->taller = $request->taller;


    // Actualizar instructor
    $pedido->profesor_id = $request->profesor;

    // Actualizar estado del pedido
    $pedido->estado = $request->estado;

     // Actualizar observaciones
     $pedido->observaciones = $request->observaciones;

    // Guardar el pedido
    $pedido->save();

        
    $pedido->save();
        
    $total_a_devolver = 0;
    
    
    foreach ($request->productos as $detalleId => $detalle) {
        
        $detallePedido = DetallePedido::findOrFail($detalleId);
        
       
        $cantidad_anterior = $detallePedido->cantidad;
        
        
        $detallePedido->cantidad = $detalle['cantidad'];
        
        
        $diferencia_cantidad = $cantidad_anterior - $detalle['cantidad'];
        
       
        $valor_a_devolver = $diferencia_cantidad * $detallePedido->precio_unitario;
        
        $total_a_devolver += $valor_a_devolver;
        
        $detallePedido->total = $detalle['cantidad'] * $detallePedido->precio_unitario;
        
        $detallePedido->save();
        
        $pedido->total += $detallePedido->total;
    }
    
    
    $pedido->save();
    
    
    return redirect()->route('pedidos.index')->with('success', 'Pedido actualizado exitosamente');
}






    // Para exportar Excel
    public function exportarExcel($id)
    {
        $pedido = Pedido::findOrFail($id);

        return Excel::download(new PedidoExport($pedido), 'pedido.xlsx');
    }



    public function clone($id)
    {
        $pedido = Pedido::findOrFail($id);
     
        $detallesPedido = $pedido->detalles()->get();

        return view('pedidos.clone', compact('pedido', 'profesores', 'areas', 'detallesPedido'));
    }


    public function cloneStore(Request $request, $id)
    {
        
        $pedidoExistente = Pedido::findOrFail($id);

        
        $nuevoPedido = new Pedido();
        $nuevoPedido->taller = $request->taller;
        $nuevoPedido->area_id = $request->area;
        $nuevoPedido->profesor_id = $request->profesor;
        $nuevoPedido->estado = $request->estado;
        $nuevoPedido->observaciones = $pedidoExistente->observaciones;
        $nuevoPedido->total = $pedidoExistente->total;
        $nuevoPedido->save();

        foreach ($pedidoExistente->detalles as $detalle) {
            $nuevoDetalle = new DetallePedido();
            $nuevoDetalle->pedido_id = $nuevoPedido->id;
            $nuevoDetalle->producto_id = $detalle->producto_id;
            $nuevoDetalle->cantidad = $detalle->cantidad;
            $nuevoDetalle->precio_unitario = $detalle->precio_unitario;
            $nuevoDetalle->total = $detalle->total;
            $nuevoDetalle->save();
        }

        return redirect()->route('pedidos.index')->with('success', 'Pedido clonado exitosamente');
    }



    
    public function destroy(Pedido $pedido)
    {
        $pedidoId = $pedido->id;

        DB::beginTransaction();

        try {
            // Eliminar los detalles del pedido
            DB::table('detallepedidos')->where('pedido_id', $pedidoId)->delete();

            // Eliminar el pedido
            DB::table('pedidos')->where('id', $pedidoId)->delete();

            // Desactivar temporalmente las restricciones de clave foránea
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            // Actualizar los pedido_id en detallepedidos
            DB::statement('
                UPDATE detallepedidos 
                SET pedido_id = pedido_id - 1 
                WHERE pedido_id > ?
            ', [$pedidoId]);

            // Actualizar los IDs de los pedidos restantes
            DB::statement('
                UPDATE pedidos 
                SET id = id - 1 
                WHERE id > ?
            ', [$pedidoId]);

            // Reactivar las restricciones de clave foránea
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            // Ajustar el auto-incremento si es necesario
            $maxId = DB::table('pedidos')->max('id');
            DB::statement('ALTER TABLE pedidos AUTO_INCREMENT = ' . ($maxId + 1));

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            // Reactivar las restricciones de clave foránea en caso de error
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            return redirect()->route('pedidos.index')->with('error', 'Error al eliminar el pedido: ' . $e->getMessage());
        }

        // Redireccionar con un mensaje de éxito
        return redirect()->route('pedidos.index')->with('success', 'Pedido eliminado y pedidos restantes actualizados con éxito.');
    }

    public function destroyfavorito($id)
    {
        // Iniciar una transacción para asegurar que ambas operaciones se realicen de forma atómica
        DB::beginTransaction();
    
        try {
            // Eliminar los detalles del pedido favorito
            DB::table('detallepedidosfavoritos')->where('pedido_id', $id)->delete();
    
            // Eliminar el pedido favorito
            DB::table('pedidosfavoritos')->where('id', $id)->delete();
    
            // Desactivar temporalmente las restricciones de clave foránea
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    
            // Actualizar los pedido_id en detallepedidosfavoritos
            DB::statement('
                UPDATE detallepedidosfavoritos 
                SET pedido_id = pedido_id - 1 
                WHERE pedido_id > ?
            ', [$id]);
    
            // Actualizar los IDs de los pedidosfavoritos restantes
            DB::statement('
                UPDATE pedidosfavoritos 
                SET id = id - 1 
                WHERE id > ?
            ', [$id]);
    
            // Reactivar las restricciones de clave foránea
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    
            // Ajustar el auto-incremento si es necesario
            $maxId = DB::table('pedidosfavoritos')->max('id');
            DB::statement('ALTER TABLE pedidosfavoritos AUTO_INCREMENT = ' . ($maxId + 1));
    
            DB::commit();
    
            // Redireccionar con un mensaje de éxito
            return redirect()->route('pedidos.indexfavoritos')->with('success', 'Pedido favorito eliminado y pedidos favoritos restantes actualizados con éxito.');
        } catch (\Exception $e) {
            DB::rollBack();
            // Reactivar las restricciones de clave foránea en caso de error
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            return redirect()->route('pedidos.indexfavoritos')->with('error', 'Error al eliminar el pedido favorito: ' . $e->getMessage());
        }
    }

    public function adicionar($id)
    {
        $productos = Producto::all();
        $pedido = Pedido::findOrFail($id); 
        
        return view('productos.adicionarproductos', compact('id', 'pedido', 'productos'));
    }

    
 


}


   

    
    
