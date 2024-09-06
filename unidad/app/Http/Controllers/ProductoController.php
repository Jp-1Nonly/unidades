<?php

// app/Http/Controllers/ProductoController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class ProductoController extends Controller
{
    public function index()
{
    $productos = Producto::all();
        return view('productos.listaproductos', compact('productos'));

}


    public function listado()
    {
        $productos = Producto::all();
        return view('productos.listaproductos', compact('productos'));
    }

    public function addToCart(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);
    
        $cart = session()->get('cart', []);
    
        // Verificar si el producto ya está en el carrito
        $existingCartItem = collect($cart)->where('id', $id)->first();
    
        if ($existingCartItem) {
            // Si el producto ya está en el carrito, agregar otro producto igual al carrito
            $cart[] = [
                'id' => $id,
                'nombre' => $producto->nombre,
                'precio' => $producto->precio,
                'cantidad' => 1,
                'medida' => $producto->medida, // Nuevo campo
            ];
        } else {
            // Si el producto no está en el carrito, simplemente agregar el producto al carrito
            $cart[$id] = [
                'id' => $id,
                'nombre' => $producto->nombre,
                'precio' => $producto->precio,
                'cantidad' => 1,
                'medida' => $producto->medida, // Nuevo campo
            ];
        }
    
        session(['cart' => $cart]);
    
        return redirect('/productos')->with('success', 'Producto agregado al carrito');
    }
    

    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session(['cart' => $cart]);
        }

        return redirect('/productos')->with('success', 'Producto eliminado del carrito');
    }



    public function addToCartadd(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);
    
        $cart = session()->get('cart', []);
    
        // Verificar si el producto ya está en el carrito
        $existingCartItem = collect($cart)->where('id', $id)->first();
    
        if ($existingCartItem) {
            // Si el producto ya está en el carrito, agregar otro producto igual al carrito
            $cart[] = [
                'id' => $id,
                'nombre' => $producto->nombre,
                'precio' => $producto->precio,
                'cantidad' => 1,
                'medida' => $producto->medida, // Nuevo campo
            ];
        } else {
            // Si el producto no está en el carrito, simplemente agregar el producto al carrito
            $cart[$id] = [
                'id' => $id,
                'nombre' => $producto->nombre,
                'precio' => $producto->precio,
                'cantidad' => 1,
                'medida' => $producto->medida, // Nuevo campo
            ];
        }
    
        session(['cart' => $cart]);
    
        return redirect()->back()->with('success', 'Producto agregado al carrito');
    }
}
