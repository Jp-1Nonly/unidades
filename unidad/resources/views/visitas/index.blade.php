@extends('layout.app')

@section('content')
    @php
        use Carbon\Carbon;
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
                        <div class="table-rep-plugin">
                            <div class="table-responsive" data-pattern="priority-columns">
                                <table id="datatable" class="table table-bordered table-striped nowrap" style="font-size: 0.75rem; padding: 0.1rem;">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Doc. visitante</th>
                                            <th>Visitante</th>
                                            <th>Vehículo</th>
                                            <th>Apto</th>
                                            <th>Residente</th>
                                            <th>Motivo</th>
                                            <th>Ingreso</th>
                                            <th>Salida</th>
                                            <th><i class="fas fa-sign-out-alt"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($visitas as $visita)
                                            <tr>
                                                <td>{{ $visita['id'] }}</td>
                                                <td>{{ $visita['documento_visitante'] }}</td>
                                                <td>{{ $visita['nombre_visitante'] . ' ' . $visita['apellido_visitante'] }}</td>
                                                <td>{{ $visita['vehiculo'] }}</td>
                                                <td>{{ $visita['apartamento'] }}</td>
                                                <td>{{ $visita['nombre'] . ' ' . $visita['apellido'] }}</td>
                                                <td>{{ $visita['motivo_visita'] }}</td>
                                                <td>
                                                    {{ Carbon::parse($visita['fecha_ingreso'])
                                                    ->setTimezone('America/Bogota')
                                                    ->format('d-m-Y H:i:s') }}
                                                </td>
                                                <td>
                                                    {{ $visita['fecha_salida'] ? Carbon::parse($visita['fecha_salida'])
                                                    ->setTimezone('America/Bogota')
                                                    ->format('d-m-Y H:i:s') : '' }}
                                                </td>
                                                <td>
                                                    @if (empty($visita['fecha_salida']))
                                                        <a href="{{ route('visitas.edit', $visita['id']) }}">
                                                            <i class="fas fa-sign-out-alt" style="color: rgb(248, 6, 6);"></i>
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
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

@push('scripts')
    <script>
        $(document).ready(function() {
            // Destruye cualquier instancia existente de DataTables en la tabla
            if ($.fn.DataTable.isDataTable('#datatable')) {
                $('#datatable').DataTable().destroy();
            }

            // Inicializa DataTables en la tabla
            $('#datatable').DataTable({
                "order": [[0, "desc"]] // Ordena por la primera columna (Id) en orden descendente
            });
        });
    </script>
@endpush
