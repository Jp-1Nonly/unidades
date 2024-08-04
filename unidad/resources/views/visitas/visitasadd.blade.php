@extends('layout.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb p-0 m-0">
                        <li class="breadcrumb-item"><a href="#">Tablero</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('residentes.create') }}">Personas</a></li>
                        <li class="breadcrumb-item active">Nuevo</li>
                    </ol>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Ingresar datos de la visita</h3>
                </div>
                <div class="card-body">
                    <div class="form">
                        <form action="{{ route('visitas.store') }}" method="POST" class="cmxform form-horizontal tasi-form" id="commentForm">
                            @csrf
                            <div class="row align-items-start">
                                <div class="col-lg-6">
                                    
                                    <div class="form-group row">
                                        <label for="visitante_id" class="col-form-label col-lg-4">Visitante</label>
                                        <div class="col-lg-8">
                                            <select name="visitante_id" id="visitante_id" class="form-control" required>
                                                <option value="">Seleccione un visitante</option>
                                                @foreach ($visitantes as $visitante)
                                                    <option value="{{ $visitante['id'] }}" {{ old('visitante_id') == $visitante['id'] ? 'selected' : '' }}>
                                                        {{ $visitante['documento_visitante'] }} - {{ $visitante['nombre_visitante'] }} {{ $visitante['apellido_visitante'] }} - {{ $visitante['descripcion'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label for="residente_id" class="col-form-label col-lg-4">Residente</label>
                                        <div class="col-lg-8">
                                            <select name="residente_id" id="residente_id" class="form-control" required>
                                                <option value="">Seleccione un residente</option>
                                                @foreach ($residentes as $residente)
                                                    <option value="{{ $residente['id'] }}">
                                                        {{ $residente['apartamento'] }} - {{ $residente['nombre'] }} {{ $residente['apellido'] }}
                                                        @if(isset($residente['id_tipo_persona']) && isset($tipos[$residente['id_tipo_persona']]))
                                                            - {{ $tipos[$residente['id_tipo_persona']]['descripcion'] }}
                                                        @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <input class="form-control" id="fecha_ingreso" type="hidden" name="fecha_ingreso" placeholder="" >

                                    <div class="form-group row">
                                        <label for="motivo_visita" class="col-form-label col-lg-4">Motivo</label>
                                        <div class="col-lg-8">
                                            <input class="form-control" id="motivo_visita" type="text" name="motivo_visita" placeholder="Ingrese motivo de la visita" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="vehiculo" class="col-form-label col-lg-4">Vehículo</label>
                                        <div class="col-lg-8">
                                            <input class="form-control" id="vehiculo" type="tel" name="vehiculo" placeholder="Número de placa. Ej: ABC123">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row mb-0">
                                <div class="offset-lg-2 col-lg-8 text-lg-center">
                                    <button class="btn btn-success btn-xs waves-effect waves-light mr-1" type="button" id="confirmButton"><i class="mdi mdi-content-save-all"></i> Guardar</button>
                                    <button class="btn btn-danger btn-xs waves-effect" type="button" onclick="window.location='{{ route('visitas.index') }}'"><i class="mdi mdi-close-box-outline"></i> Cancelar</button>
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
        document.addEventListener('DOMContentLoaded', function() {
            var now = new Date();
            var year = now.getFullYear();
            var month = ('0' + (now.getMonth() + 1)).slice(-2);
            var day = ('0' + now.getDate()).slice(-2);
            var hours = ('0' + now.getHours()).slice(-2);
            var minutes = ('0' + now.getMinutes()).slice(-2);
            var datetimeLocal = `${year}-${month}-${day}T${hours}:${minutes}`;
            document.getElementById('fecha_ingreso').value = datetimeLocal;
        });

        document.getElementById('confirmButton').addEventListener('click', function(event) {
            event.preventDefault();
            Swal.fire({
                toast: 'true',
                title: '¿Está seguro?',
                text: "¡Desea guardar los datos de la visita!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, guardar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('commentForm').submit();
                }
            });
        });
    </script>
@endsection
