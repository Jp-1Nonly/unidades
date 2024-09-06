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
                    <li class="breadcrumb-item active">Seleccionar productos</li>
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
                <a href="{{ url('/carrito') }}" class="btn btn-info ml-2 btn-sm"><i class="fa-solid fa-cart-shopping"></i> Ver Carrito</a>
            </div>
            <div class="card-body">
                <div class="table-rep-plugin">
                    <div class="table-responsive" data-pattern="priority-columns">
                        <table id="datatable" class="table table-bordered table-striped nowrap">
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
                                            <form action="{{ url('/add-to-cart', $producto->id) }}" method="post">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm"><i class="fa-solid fa-plus"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- Cierre de card-body -->
        </div> <!-- Cierre de card -->
    </div> <!-- Cierre de col-md-12 -->
</div> <!-- Cierre de row -->

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

@endsection <!-- Cierre de la sección content -->
