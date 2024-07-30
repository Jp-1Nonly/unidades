@extends('layout.app')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Residentes</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb p-0 m-0">
                        <li class="breadcrumb-item"><a href="#">Tablero</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('residentes.create') }}">residentes</a></li>
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

                    <a href="{{ route('residentes.create') }}" class="btn btn-danger btn-xs"><i
                            class="mdi mdi-account-multiple"></i> Nuevo</a>
                </div>


                <div class="card-body">

                    @if (count($residentes) > 0)
                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Apartamento</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Edad</th>
                                    <th>Correo</th>
                                    <th>Celular</th>
                                    <th>Mascota</th>
                                    <th>Categoría</th>
                                    <th>Discapacidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($residentes as $residente)
                                    <tr>
                                        <td>{{ $residente['apartamento'] }}</td>
                                        <td>{{ $residente['nombre'] }}</td>
                                        <td>{{ $residente['apellido'] }}</td>
                                        <td>{{ $residente['edad'] }}</td>
                                        <td>{{ $residente['correo'] }}</td>
                                        <td>{{ $residente['telefono'] }}</td>
                                        <td>{{ $residente['mascota'] }}</td>
                                        <td>{{ $residente['condicion'] }}</td>
                                        <td>{{ $residente['discapacidad'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No hay residentes para mostrar.</p>
                    @endif


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
