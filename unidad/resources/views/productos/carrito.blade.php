@extends('layout.app')

@section('content')

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title">Nuevo pedido</h4>
            <div class="page-title-right">
                <ol class="breadcrumb p-0 m-0">
                    <li class="breadcrumb-item"><a href="#">Tablero</a></li>
                    <li class="breadcrumb-item"><a href="#">Pedido</a></li>
                    <li class="breadcrumb-item active">Agregar cantidades</li>
                </ol>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <a href="{{ url('/productos') }}" class="btn btn-success btn-sm"><i class="fa-solid fa-file-circle-plus"></i> Agregar Productos</a>
            </div>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">
        <i class="fa-solid fa-utensils purple_color2"></i> Productos seleccionados
    </div>

    @if (session('cart'))
        <div class="card-body">
            <div class="card-datatable table-responsive">
                <!-- Formulario para actualizar cantidades -->
                <form action="{{ route('carrito.update') }}" method="post">
                    @csrf
                    @method('PUT')
                    <table id="datatables" class="table table-striped">
                        <thead class="thead-light">
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
                        <button type="submit" class="btn btn-primary btn-sm"><i class="fa-solid fa-rotate"></i> Actualizar Cantidades</button>
                    </div>
                </form>
                
                <!-- Formulario para vaciar el carrito -->
                <form action="{{ route('empty-cart') }}" method="post">
                    @csrf
                    @method('DELETE')
                    <div class="mt-3">
                        <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-cart-arrow-down"></i> Vaciar Carrito</button>
                    </div>
                </form>

            </div>

            <!-- Mostrar el total del pedido -->
            <div class="mt-4">
                <h6>Total pedido: ${{ number_format(array_sum(array_map(fn($item) => $item['precio'] * $item['cantidad'], session('cart'))), 0, ',', '.') }}</h6>
                <br>
            </div>

            <!-- Formulario para procesar el pedido -->
            <form id="procesarPedidoForm" action="{{ url('/procesar-pedido') }}" method="post">
                @csrf
                <div class="mt-4">
                    <h6>Selecciona Proveedor</h6>
                    <select name="proveedor" id="proveedor" class="form-control">
                        @foreach ($proveedor as $proveedores)
                        <option value="{{ $proveedores['id'] }}">{{ $proveedores['nombre'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mt-4">
                    <h6>Observaciones</h6>
                    <input class="form-control" type="text" name="observaciones">
                </div>

                <input type="hidden" name="tipo_pedido" id="tipo_pedido" value="normal">

                <div class="mt-4">
                    <button type="button" onclick="setPedidoFavorito()" class="btn btn-success btn-sm">
                        <i class="fa-solid fa-building-columns"></i> Guardar
                    </button>
                </div>
            </form>

            <!-- Script para cambiar el tipo de pedido y enviar el formulario -->
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

@if (session('success'))
    @push('scripts')
        <script>
            Swal.fire({
                position: "top-end",
                toast: true,
                icon: 'success',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 1500
            });
        </script>
    @endpush
@endif

@if ($errors->any())
    @push('scripts')
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                html: `
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                `
            });
        </script>
    @endpush
@endif

@endsection
