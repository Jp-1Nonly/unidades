@extends('layout.app')

@section('content')

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title">Colaboradores</h4>
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
               
                <a href="{{ route('personas.create') }}" class="btn btn-danger btn-xs"><i class="mdi mdi-account-multiple"></i> Nuevo</a>
            </div>
            
    
            <div class="card-body">
                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
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
        </div>
    </div>
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
