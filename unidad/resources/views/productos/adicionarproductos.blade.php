<!-- resources/views/productos/index.blade.php -->

@extends('layout.app')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h5 class="mt-4">Pedido {{ $id }}</h5>
            <ol class="breadcrumb mb-4">
          
                <li class="breadcrumb-item active">Adicionar productos al pedido {{ $id }}</li>
            </ol>
                
          
            <div class="card mb-1">
                <div class="card-body">
                    <div class="text-left mt-1">
          
                        <a href="{{ url('/carritoadd/' . $id) }}" class="btn btn-danger ml-2 btn-sm"><i class="fa-solid fa-cart-plus"></i> Ver Carrito adición</a>

                        
                    </div>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fa-solid fa-utensils purple_color2"></i>
                    Seleccionar de productos
                </div>
                <br>
                <div class="card-body">
                    <div class="card-datatable table-responsive">
                        <table id="datatablesSimple" class="datatables-basic table border-top">
                            <thead>
                             <tr>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th>Medida</th>
                                <th>Precio</th>
                                <th>Agregar</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @foreach ($productos as $producto)
                                <tr>
                                    <td>{{ $producto->id }}</td>
                                    <td>{{ $producto->nombre }}</td>
                                    <td>{{ $producto->medida }}</td>
                                    <td>${{ number_format($producto->precio, 0, ',', '.') }}</td>
                                    <td>
                                        <form action="{{ url('/add-to-cartadd', $producto->id) }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-bag-plus-fill"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
    </main>

    
@endsection


