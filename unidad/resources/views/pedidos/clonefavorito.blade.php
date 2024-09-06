@extends('layoutsuse.app')

@section('content')
<main>
    <div class="container-fluid px-4">
        <h5 class="mt-4">Duplicar Pedido banco - {{$pedido->taller}}</h5>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fa-solid fa-copy orange_color"></i>
                 <strong>SÓLO DAR CLIC EN EL BOTÓN</strong> - Luego edita el pedido
            </div>
            <div class="card-body">
                <form action="{{ route('pedidos.clone.storefavorito', $pedido->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="pedido_favorito_id" value="{{ $pedido->id }}">


                    <!-- Agregar la tabla de detalles del pedido aquí -->
                    <h5 class="mt-4">Detalles del Pedido</h5>
                    <h6 class="mt-4">Nombre del taller: {{$pedido->taller}}</h6>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Producto</th>
                                <th>Unidad de medida</th>
                                <th>Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($detallesPedido as $detalle)
                            <tr>
                                <td>
                                    @if ($detalle->producto)
                                    {{ $detalle->producto->item }}
                                    
                                    @else
                                    Producto no encontrado
                                    @endif
                                </td>
                                <td>{{ $detalle->producto->nombre }}</td>
                                <td>{{ $detalle->medida }}</td>
                                <td>{{ $detalle->cantidad }}</td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- Fin de la tabla de detalles del pedido -->
                    <button type="submit" class="btn btn-warning"><i class="fa-regular fa-clone"></i> Duplicar</button>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection