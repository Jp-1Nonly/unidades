@extends('layout.app')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb p-0 m-0">
                        <li class="breadcrumb-item"><a href="#">Tablero</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('personas.create') }}">Personas</a></li>
                        <li class="breadcrumb-item active">Nuevo</li>
                    </ol>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Ingresar datos</h3>
                </div>
                <div class="card-body">
                    <div class="form">
                        <form action="{{ route('visitantes.store') }}" method="POST" class="cmxform form-horizontal tasi-form" id="commentForm">
                            @csrf
                            <div class="row align-items-start">
                                <div class="col-lg-6"> <!-- Columna izquierda -->
                                    <div class="form-group row">
                                        <label for="documento" class="col-form-label col-lg-4">Documento</label>
                                        <div class="col-lg-8">
                                            <input class="form-control" id="documento_visitante" type="text" name="documento_visitante" placeholder="Ingresa el documento" aria-required="true" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="nombre_visitante" class="col-form-label col-lg-4">Nombre</label>
                                        <div class="col-lg-8">
                                            <input class="form-control" id="nombre_visitante" type="text" name="nombre_visitante" placeholder="Ingresa el nombre" aria-required="true" required>
                                        </div>
                                    </div>
                        
                                    <div class="form-group row">
                                        <label for="apellido_visitante" class="col-form-label col-lg-4">Apellido</label>
                                        <div class="col-lg-8">
                                            <input class="form-control" id="apellido_visitante" type="text" name="apellido_visitante" placeholder="Ingresa el apellido" aria-required="true" required>
                                        </div>
                                    </div> 
                                    <div class="form-group row">
                                        <label for="tipo" class="col-form-label col-lg-4">Tipo de persona</label>
                                        <div class="col-lg-8">
                                            <select class="form-control" name="id_tipo_visitante" id="tipo" required>
                                                <option value="" disabled selected>Elige un tipo</option>
                                                @foreach ($tipos as $tipo)
                                                    <option value="{{ $tipo['id'] }}">{{ $tipo['descripcion'] }}</option>
                                                @endforeach
                                            </select>
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
                    <!-- .form -->
                </div>
                <!-- card-body -->
            </div>
            <!-- card -->
        </div>
        <!-- col -->
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('confirmButton').addEventListener('click', function(event) {
                event.preventDefault();
                Swal.fire({
                    title: '¿Está seguro?',
                    text: "¡Desea guardar los datos del visitante!",
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
        });
    </script>
@endsection
