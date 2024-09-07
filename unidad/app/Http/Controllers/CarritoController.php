<?php

namespace App\Http\Controllers;
use App\Models\Area;
use App\Models\DetallePedidoFavorito;
use App\Models\PedidoFavorito;
use Illuminate\Http\Request;
use App\Models\DetallePedido;

use App\Models\Proveedor;
use App\Models\Producto;
use App\Models\Pedido;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;

class CarritoController extends Controller
{
    public function index(Request $request)
    {
        
        $producto = Producto::all();
        
        $proveedor = Proveedor::all();
        $pedidos = Pedido::all();
        $detalle = DetallePedido::all();

        // Obtener el carrito actual de la sesión
        $cart = session()->get('cart', []);

       
        $totalConsumo = $pedidos->sum('total');       
           
       // Retornar la vista del carrito con los datos necesarios
        return view('productos.carrito', compact('cart', 'proveedor', 'producto'));
    }



    public function indexadd($id)
    {
              
        $producto = Producto::all();
  
        $proveedor = Proveedor::all();

        // Obtener el carrito actual de la sesión
        $cart = session()->get('cart', []);

        // Traer los datos de areas.index
        $totalAsignado = session('totalAsignado');
        $totalAdicion = session('totalAdicion');
        $totalConsumo = session('totalConsumo');
        $totalSaldo = $totalAsignado + $totalAdicion - $totalConsumo;

        // Retornar la vista del carrito con los datos necesarios
        return view('productos.carritoadd', compact('cart', 'proveedor',  'producto', 'totalSaldo', 'id'));
    }

    public function indexaddfav($id)
    {
        
        $producto = Producto::all();
      
        $proveedor = Proveedor::all();
              

        // Obtener el carrito actual de la sesión
        $cart = session()->get('cart', []);

        // Traer los datos de areas.index
        $totalAsignado = session('totalAsignado');
        $totalAdicion = session('totalAdicion');
        $totalConsumo = session('totalConsumo');
        $totalSaldo = $totalAsignado + $totalAdicion - $totalConsumo;

        // Retornar la vista del carrito con los datos necesarios
        return view('productos.carritoaddfav', compact('cart','proveedor', 'areas', 'producto', 'totalSaldo', 'id', 'pedido'));
    }

    public function update(Request $request)
    {
        // Obtener el carrito actual de la sesión
        $cart = session()->get('cart', []);

        // Recorrer todos los elementos del carrito y actualizar sus cantidades
        foreach ($cart as $id => $item) {
            $cart[$id]['cantidad'] = $request->input('cantidad_' . $id);
        }

        // Actualizar el carrito en la sesión
        session(['cart' => $cart]);

        // Redirigir de vuelta al carrito con un mensaje de éxito
        return redirect('/carrito')->with('success', 'Carrito actualizado');
    }
    public function updateadd(Request $request)
    {
        // Obtener el carrito actual de la sesión
        $cart = session()->get('cart', []);

        // Recorrer todos los elementos del carrito y actualizar sus cantidades
        foreach ($cart as $id => $item) {
            $cart[$id]['cantidad'] = $request->input('cantidad_' . $id);
        }

        // Actualizar el carrito en la sesión
        session(['cart' => $cart]);

        // Redirigir de vuelta al carrito con un mensaje de éxito
        return redirect()->route('carritoadd', ['id' => $request->input('pedido_id')])->with('success', 'Carrito actualizado');
    }

    public function updateaddfav(Request $request)
    {
        // Obtener el carrito actual de la sesión
        $cart = session()->get('cart', []);

        // Recorrer todos los elementos del carrito y actualizar sus cantidades
        foreach ($cart as $id => $item) {
            $cart[$id]['cantidad'] = $request->input('cantidad_' . $id);
        }

        // Actualizar el carrito en la sesión
        session(['cart' => $cart]);

        // Redirigir de vuelta al carrito con un mensaje de éxito
        return redirect()->route('carritoaddfav', ['id' => $request->input('pedido_id')])->with('success', 'Carrito actualizado');
    }


    public function procesarPedido(Request $request)
{
    $pedido = new Pedido();
    $pedido->Proveedor_id = $request->input('proveedor');
    $pedido->observaciones = $request->input('observaciones');
    $pedido->total = array_sum(array_map(function ($item) {
        return $item['precio'] * $item['cantidad'];
    }, session('cart')));
    $pedido->save();

    $pedidoId = $pedido->id;

    foreach (session('cart') as $id => $item) {
        $detallePedido = new DetallePedido();
        $detallePedido->pedido_id = $pedidoId;
        $detallePedido->producto_id = $item['id'];
        $detallePedido->cantidad = $item['cantidad'];
        $detallePedido->precio_unitario = $item['precio'];
        $detallePedido->total = $item['precio'] * $item['cantidad'];
        $detallePedido->medida = $item['medida'];
        $detallePedido->save();
    }

    session(['cart' => []]);

    return redirect()->route('pedidos.index');
}

public function procesarPedidoadd(Request $request)
{
    $pedidoId = $request->input('pedido_id');

    foreach (session('cart') as $id => $item) {
        $detallePedido = new DetallePedido();
        $detallePedido->pedido_id = $pedidoId;
        $detallePedido->producto_id = $item['id'];
        $detallePedido->cantidad = $item['cantidad'];
        $detallePedido->precio_unitario = $item['precio'];
        $detallePedido->total = $item['precio'] * $item['cantidad'];
        $detallePedido->medida = $item['medida']; // Conserva el campo 'medida' si es necesario
        // Eliminar la línea relacionada con 'area_id'
        $detallePedido->save();
    }

    $detalleSums = DB::table('detallepedidos')
        ->select('pedido_id', DB::raw('SUM(total) AS suma_total'))
        ->where('pedido_id', $pedidoId)
        ->groupBy('pedido_id')
        ->first();

    if ($detalleSums) {
        $pedido = Pedido::find($pedidoId);
        $pedido->total = $detalleSums->suma_total;
        $pedido->save();
    }

    session(['cart' => []]);

    return redirect()->route('pedidos.index')->with('success', 'Pedido procesado correctamente.');
}
   
    public function removeItem($id)
    {
        $cart = session()->get('cart', []);

        // Verificar si el producto está en el carrito y eliminarlo
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session(['cart' => $cart]);
        }

        return redirect()->back()->with('success', 'Producto eliminado del carrito');
    }


    public function emptyCart()
    {
        session()->forget('cart');
        return redirect()->back()->with('success', '¡El carrito se ha vaciado correctamente!');
    }


    public function calcularSaldo(Request $request)
    {
        // Validar el request para asegurarse de que 'area_id' está presente
        $request->validate([
            'area_id' => 'required|exists:areas,id',
        ]);

    
      
        // Obtener el carrito actual de la sesión
        $cart = session()->get('cart', []);

        // Traer los datos de areas.index
        $totalAsignado = session('totalAsignado');
        $totalAdicion = session('totalAdicion');
        $totalConsumo = session('totalConsumo');
        $totalSaldo = $totalAsignado + $totalAdicion - $totalConsumo;

        $Proveedor = Proveedor::all();

        return view('productos.carrito', compact('saldoarea', 'totalSaldo','Proveedor'));
    }
    
}
