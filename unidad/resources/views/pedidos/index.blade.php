@extends('layout.app')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Lista de pedidos</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb p-0 m-0">
                        <li class="breadcrumb-item"><a href="#">Tablero</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('personas.create') }}">Personal</a></li>
                        <li class="breadcrumb-item active">Listado</li>
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

                    <a href="{{ route('productos.lista') }}" class="btn btn-danger btn-xs"><i
                            class="mdi mdi-account-multiple"></i> Nuevo</a>
                </div>


                <div class="card-body">

                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Fecha</th>
                                <th>Valor</th>
                                <th>Estado</th>
                              
                                <th>PDF</th>
                                <th>Eliminar</th>
                                <th>Adición</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pedidos as $pedido)
                                <tr>
                                    <td>{{ $pedido->id }}</td>
                                    <td>{{ $pedido->created_at->format('Y-m-d') }}</td>
                                    <td>${{ number_format($sumaPorPedido[$pedido->id] ?? 0, 0, '.', ',') }}</td>
                                    <td>{{ $pedido->estado }}</td>
                                    
                                    <td>

                                        <a href="{{ route('pedidos.show', $pedido->id) }}" class="btn btn-danger btn-sm">
                                            <i class="fa-solid fa-file-pdf"></i>
                                        </a>

                                    </td>
                                   
                                    <td>
                                        @if ($pedido->estado == 'Enviado')
                                            <form action="{{ route('pedidos.destroy', $pedido->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('¿Estás seguro de que deseas eliminar este pedido?')">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($pedido->estado == 'Enviado')
                                            <a class="btn btn-primary btn-sm"
                                                href="{{ route('pedidos.adicionar', $pedido->id) }}">
                                                <i class="fa-solid fa-plus"></i></span>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

    </div>
    @if (session('success'))
        @push('scripts')
            <script>
                Swal.fire({
                    position: "top-end",
                    toast: 'true',
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
