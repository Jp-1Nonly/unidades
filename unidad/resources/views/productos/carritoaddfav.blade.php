@extends('layout.app')

@section('content')
<main>
    <div class="container-fluid px-4">
        <h5 class="mt-4">Adición para el pedido: {{ $pedido->taller }}</h5>
        <ol class="breadcrumb mb-4">
     
            <li class="breadcrumb-item active">Agregar cantidades</li>
        </ol>
    </div>

    <div class="card mb-1">
        <div class="card-body">
            <div class="text-left mt-1">
                
                <a href="{{ route('pedidosfavoritos.adicionarfav', $id) }}" class="btn btn-danger btn-sm">Adicionar + Productos</a>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fa-solid fa-utensils purple_color2"></i>
            Productos para adicionar
        </div>

        @if (session('cart'))
        <div class="card-body">
            <div class="card-datatable table-responsive">
                <form action="{{ route('carritoaddfav.updatefav') }}" method="post">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="pedido_id" value="{{ $id }}">
                    <table id="datatables" class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>Item</th>
                                <th>Producto</th>
                                <th>Medida</th>
                                <th>Precio Unitario</th>
                                <th>Cantidad</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cart as $key => $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item['nombre'] }}</td>
                                <td>{{ $item['medida'] }}</td>
                                <td>${{ number_format($item['precio'], 0, ',', '.') }}</td>
                                <td>
                                    <input type="number" name="cantidad_{{ $key }}" value="{{ $item['cantidad'] }}" min="0" class="form-control" style="font-size: 12px;" step="0.1">
                                </td>
                                <td>${{ number_format($item['precio'] * $item['cantidad'], 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary btn-sm">Actualizar Cantidades</button>
                    </div>
                </form>
                <form action="{{ route('empty-cart') }}" method="post">
                    @csrf
                    @method('DELETE')
                    <div class="mt-3">
                        <button type="submit" class="btn btn-danger btn-sm">Vaciar Carrito</button>
                    </div>
                </form>
            </div>

            <form id="procesarPedidoForm" action="{{ url('/procesar-pedidoaddfav') }}" method="post">
                @csrf
                <div class="mt-4">
                    <p>Total esta adición:
                        ${{ number_format(array_sum(array_map(function ($item) {
                            return $item['precio'] * $item['cantidad'];
                        }, session('cart'))), 0, ',', '.') }}
                    </p>
                    <p>
                        @php
                        $saldoGlobal = $totalSaldo - array_sum(array_map(function ($item) {
                            return $item['precio'] * $item['cantidad'];
                        }, session('cart')));
                        $saldoGlobalF = number_format($saldoGlobal, 0, ',', '.');
                        @endphp
                        @if ($saldoGlobal < 0)
                        <div class="alert alert-danger mt-4" role="alert">
                            Saldo con este pedido:<strong> ${{ $saldoGlobalF }}</strong> - No es posible realizar el pedido por falta de saldo. <br><strong>Revisar cantidad en caso de llevar al Banco de Pedidos.</strong>
                        </div>
                        @else
                        <p>Saldo con este pedido: ${{ $saldoGlobalF }}</p>
                        @endif
                    </p>
                </div>

                
                <input type="hidden" name="tipo_pedido" id="tipo_pedido" value="normal">
                <input type="hidden" name="pedido_id" value="{{ $id }}">

                <div class="mt-4">
                    <button type="button" onclick="setPedidoFavorito()" class="btn btn-warning btn-sm">
                        <i class="fa-solid fa-cart-plus"></i> Aceptar adición
                    </button>
                </div>
            </form>

            <script>
                function setPedidoFavorito() {
                    document.getElementById("tipo_pedido").value = "favorito";
                    document.getElementById("procesarPedidoForm").submit();
                }
            </script>
        </div>
        @else
        <div class="card-body">
           
            <div class="alert alert-danger mt-4" role="alert">
                El carrito está vacío
            </div>
        </div>
        @endif
    </div>
</main>
@endsection
