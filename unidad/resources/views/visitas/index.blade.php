@extends('layout.app')

@section('content')
@php
    use \Carbon\Carbon;
@endphp

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title">Lista de visitas</h4>
            <div class="page-title-right">
                <ol class="breadcrumb p-0 m-0">
                    <li class="breadcrumb-item"><a href="#">Tablero</a></li>
                    <li class="breadcrumb-item"><a href="#">Visitas</a></li>
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
                <a href="{{ route('visitas.create') }}" class="btn btn-danger btn-xs">
                    <i class="far fa-address-book"></i> Nueva Visita
                </a>
            </div>
            <div class="card-body">
                @if (count($visitas) > 0)
                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Doc. visitante</th>
                                <th>Nombre visitante</th>
                                <th>Apartamento</th>
                                <th>Residente</th>
                                <th>Motivo</th>
                                <th>Ingreso</th>
                                <th>Salida</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($visitas as $visita)
                                <tr>
                                    <td>{{ $visita['documento_visitante'] }}</td>
                                    <td>{{ $visita['nombre_visitante'] . ' ' . $visita['apellido_visitante'] }}</td>
                                    <td>{{ $visita['apartamento'] }}</td>
                                    <td>{{ $visita['nombre'] . ' ' . $visita['apellido'] }}</td>
                                    <td>{{ $visita['motivo_visita'] }}</td>
                                    <td>{{ Carbon::parse($visita['fecha_ingreso'])->format('d-m-Y H:i:s') }}</td>
                                    <td>{{ $visita['fecha_salida'] ? Carbon::parse($visita['fecha_salida'])->format('d-m-Y H:i:s') : '' }}</td>
                                    <td><a class="btn btn-danger btn-sm" href="{{ route('visitas.edit', $visita['id']) }}">
                                        <i class="fas fa-sign-out-alt" style="color: rgb(255, 255, 255);"></i>
                                    </a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>No hay visitas para mostrar.</p>
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
