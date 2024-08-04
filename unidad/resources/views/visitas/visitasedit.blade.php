@extends('layout.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb p-0 m-0">
                    <li class="breadcrumb-item"><a href="#">Tablero</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('visitas.index') }}">Visitas</a></li>
                    <li class="breadcrumb-item active">Editar</li>
                </ol>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="alert alert-danger" role="alert">
                <h3 class="card-title text-danger">¿SEGURO de dar salida a la visita?</h3>
            </div>
            <div class="card-body">
                <div class="form">
                    <form action="{{ route('visitas.update', $visita['id']) }}" method="POST" class="cmxform form-horizontal tasi-form" id="commentForm">
                        @csrf
                        @method('PUT')
                        <div class="row align-items-start">
                            <div class="col-lg-6">
                                <div class="form-group row">
                                    <label for="visitante_id" class="col-form-label col-lg-4">Visitante</label>
                                    <div class="col-lg-8">
                                        <select name="visitante_id" id="visitante_id" class="form-control" disabled>
                                            <option value="">Seleccione un visitante</option>
                                            @foreach ($visitantes as $visitante)
                                                <option value="{{ $visitante['id'] }}" {{ $visita['visitante_id'] == $visitante['id'] ? 'selected' : '' }}>
                                                    {{ $visitante['documento_visitante'] }} - {{ $visitante['nombre_visitante'] }} {{ $visitante['apellido_visitante'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <!-- Campo oculto para enviar el valor del visitante_id -->
                                        <input type="hidden" name="visitante_id" value="{{ $visita['visitante_id'] }}" required>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label for="residente_id" class="col-form-label col-lg-4">Residente</label>
                                    <div class="col-lg-8">
                                        <select name="residente_id_display" id="residente_id_display" class="form-control" disabled>
                                            <option value="">Seleccione un residente</option>
                                            @foreach ($residentes as $residente)
                                                <option value="{{ $residente['id'] }}" {{ $visita['residente_id'] == $residente['id'] ? 'selected' : '' }}>
                                                    {{ $residente['apartamento'] }} - {{ $residente['nombre'] }} {{ $residente['apellido'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <!-- Campo oculto para enviar el valor del residente_id -->
                                        <input type="hidden" name="residente_id" value="{{ $visita['residente_id'] }}" required>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label for="fecha_ingreso" class="col-form-label col-lg-4">Fecha de Ingreso</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" id="fecha_ingreso" type="datetime-local" name="fecha_ingreso" value="{{ date('Y-m-d\TH:i', strtotime($visita['fecha_ingreso'])) }}" readonly>
                                    </div>
                                </div>

                                <div class="col-lg-8">
                                    <input class="form-control" id="fecha_salida" type="hidden" name="fecha_salida" value="{{ $visita['fecha_salida'] ? date('Y-m-d\TH:i', strtotime($visita['fecha_salida'])) : '' }}">
                                </div>

                                <div class="form-group row">
                                    <label for="motivo_visita" class="col-form-label col-lg-4">Motivo</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" id="motivo_visita" type="text" name="motivo_visita" placeholder="Ingrese motivo de la visita" value="{{ $visita['motivo_visita'] }}" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="vehiculo" class="col-form-label col-lg-4">Vehículo</label>
                                    <div class="col-lg-8">
                                        <input class="form-control" id="vehiculo" type="tel" name="vehiculo" placeholder="Número de placa. Ej: ABC123" value="{{ $visita['vehiculo'] }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row mb-0">
                            <div class="offset-lg-2 col-lg-8 text-lg-center">
                                <button class="btn btn-success btn-xs waves-effect waves-light mr-1" type="button" id="confirmButton"><i class="fas fa-angle-double-right"></i> Dar Salida</button>
                                <button class="btn btn-danger btn-xs waves-effect" type="button" onclick="window.location='{{ route('visitas.index') }}'"><i class="far fa-stop-circle"></i> Cancelar</button>
                            </div>
                        </div>
                    </form>

                    @if (session('success'))
                        <div>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('confirmButton').addEventListener('click', function(event) {
    event.preventDefault();
    Swal.fire({
        title: '¿Está seguro?',
        text: "¡No podrá revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, dar salida'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('commentForm').submit();
        }
    });
});
</script>
@endsection
