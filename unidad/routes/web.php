<?php

use App\Http\Controllers\CarritoController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartamentosController;
use App\Http\Controllers\DetallePedidoController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ResidentesController;
use App\Http\Controllers\VisitantesController;
use App\Http\Controllers\VisitasController;
use App\Http\Controllers\PersonasController;
use App\Http\Controllers\ProductoController;
use Barryvdh\DomPDF\Facade\Pdf;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas para Departamentos
Route::get('/departamentos', [DepartamentosController::class, 'index'])->name("departamentos.index");
Route::get('/departamentos/create', [DepartamentosController::class, 'create'])->name('departamentos.create');
Route::post('/departamentosadd', [DepartamentosController::class, 'store'])->name('departamentos.store');

// Rutas para Personas
Route::get('/personas', [PersonasController::class, 'index'])->name('personas.index');
Route::get('personas/create', [PersonasController::class, 'create'])->name('personas.create');
Route::post('/personas', [PersonasController::class, 'store'])->name('personas.store');

// Rutas para visitantes
Route::get('/visitantes', [VisitantesController::class, 'index'])->name('visitantes.index');
Route::get('/visitantes/create', [VisitantesController::class, 'create'])->name('visitantes.create');
Route::post('/visitantesadd', [VisitantesController::class, 'store'])->name('visitantes.store');

// Rutas para residentes
Route::get('/residentes', [ResidentesController::class, 'index'])->name('residentes.index');
Route::get('/residentes/create', [ResidentesController::class, 'create'])->name('residentes.create');
Route::post('/residentesadd', [ResidentesController::class, 'store'])->name('residentes.store');

// Rutas para visitas
Route::get('/visitas', [VisitasController::class, 'index'])->name('visitas.index');
Route::get('/visitas/create', [VisitasController::class, 'create'])->name('visitas.create');
Route::post('visitasadd',[VisitasController::class, 'store'])->name('visitas.store');

Route::get('visitas/{id}/edit', [VisitasController::class, 'edit'])->name('visitas.edit');
Route::put('visitas/{id}', [VisitasController::class, 'update'])->name('visitas.update');

// Rutas para Pedidos
Route::get('/pedidos', [PedidoController::class, 'index'])->name('pedidos.index');
Route::get('/pedidos/index2', [PedidoController::class, 'index2'])->name('pedidos.index2');
Route::get('/pedidos/{id}', [PedidoController::class, 'show'])->name('pedidos.show');
Route::post('/realizar-pedido', [PedidoController::class, 'store'])->name('pedido.store');
Route::get('/pedidos/{pedido}/edit', [PedidoController::class, 'edit'])->name('pedidos.edit');
Route::put('/pedidos/{pedido}', [PedidoController::class, 'update'])->name('pedidos.update');
Route::get('/pedidos/{pedido}/excel', [PedidoController::class, 'tabla'])->name('pedidos.tabla');
Route::get('pedidos/{id}/clone', [PedidoController::class, 'clone'])->name('pedidos.clone');
Route::post('pedidos/{id}/clone', [PedidoController::class, 'cloneStore'])->name('pedidos.clone.store');
Route::get('/verificar_saldo', [CarritoController::class, 'verificarSaldo'])->name('verificar_saldo');
Route::delete('/pedidos/{pedido}', [PedidoController::class, 'destroy'])->name('pedidos.destroy');
Route::get('/detallepedidos/delete/{id}', [DetallePedidoController::class, 'delete'])->name('detallepedidos.delete');
Route::get('/pedidos/{pedido}/adicionar', [PedidoController::class, 'adicionar'])->name('pedidos.adicionar');

Route::get('/generate-pdf/{id}', [PdfController::class, 'generarpdf'])->name('generate.pdf');

 // Rutas para Productos
 Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');
 Route::get('/productos/listaproductos', [ProductoController::class, 'listado'])->name('productos.lista');
 Route::post('/add-to-cart/{id}', [ProductoController::class, 'addToCart']);
 Route::delete('/remove-from-cart/{id}', [ProductoController::class, 'removeFromCart']);
 Route::post('/add-to-cartadd/{id}', [ProductoController::class, 'addToCartadd']);

  // Rutas para Carrito
  Route::get('/carrito', [CarritoController::class, 'index']);
  Route::get('/carritoadd/{id}', [CarritoController::class, 'indexadd']);
  Route::put('/update-cart', [CarritoController::class, 'update'])->name('carrito.update');
  Route::put('/update-cartadd', [CarritoController::class, 'updateadd'])->name('carritoadd.update');
  Route::put('/update-cartaddfav', [CarritoController::class, 'updateaddfav'])->name('carritoaddfav.updatefav');
  Route::get('/carritoadd/{id}', [CarritoController::class, 'indexadd'])->name('carritoadd');
  Route::get('/carritoaddfav/{id}', [CarritoController::class, 'indexaddfav'])->name('carritoaddfav');
  Route::delete('/clear-cart', [CarritoController::class, 'clearCart']);
  Route::delete('/remove-item/{id}', [CarritoController::class, 'removeItem'])->name('remove-item');
  Route::post('/add-discount', [CarritoController::class, 'addDiscount']);
  Route::delete('/remove-discount', [CarritoController::class, 'removeDiscount']);
  Route::get('/checkout', [CarritoController::class, 'checkout']);
  Route::post('/procesar-pedido', [CarritoController::class, 'procesarPedido']);
  Route::post('/procesar-pedidoadd', [CarritoController::class, 'procesarPedidoadd']);
  Route::post('/procesar-pedidoaddfav', [CarritoController::class, 'procesarPedidoaddfav']);
  Route::post('/procesar-favorito', [CarritoController::class, 'procesarPedidoFavorito']);
  Route::delete('/empty-cart', [CarritoController::class, 'emptyCart'])->name('empty-cart');
  Route::post('/update-cart-all', [CarritoController::class, 'updateAll'])->name('update-cart-all');    
  Route::get('/productos/consulta', [CarritoController::class, 'mostrarFormularioSaldo'])->name('productos.mostrarSaldoForm');
  Route::post('/productos/saldoarea', [CarritoController::class, 'calcularSaldoArea'])->name('productos.saldoarea');


require __DIR__.'/auth.php';
