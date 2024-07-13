@extends('layout.app')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Nueva persona</h4>
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
                        <form action="{{ route('personas.store') }}" method="POST" class="cmxform form-horizontal tasi-form" id="commentForm">
                            @csrf
                            <div class="row align-items-start">
                                <div class="col-lg-6"> <!-- Columna izquierda -->
                                    <h3 class="card-title">Visitante</h3><br>
                                    <div class="form-group row">
                                        <label for="nombre_departamento" class="col-form-label col-lg-4">Documento</label>
                                        <div class="col-lg-8">
                                            <input class="form-control" id="documento" type="text" name="documento" placeholder="Ingresa el documento" aria-required="true" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="nombre_departamento" class="col-form-label col-lg-4">Nombre</label>
                                        <div class="col-lg-8">
                                            <input class="form-control" id="nombre_persona" type="text" name="nombre_persona" placeholder="Ingresa el nombre" aria-required="true" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="apellido" class="col-form-label col-lg-4">Apellidos</label>
                                        <div class="col-lg-8">
                                            <input class="form-control" id="apellido" type="text" name="apellido" placeholder="Ingresa el apellido" aria-required="true" required>
                                        </div>
                                    </div> 
                                    
                                    <input class="form-control" id="nombre_persona" type="hidden" name="nombre_persona" placeholder="Ingresa el nombre" aria-required="true" required>

                                                                       
                                </div>
                              
                            </div>
                            <hr>
                            <div class="form-group row mb-0">
                                <div class="offset-lg-2 col-lg-8 text-lg-center">
                                    <button class="btn btn-success btn-xs waves-effect waves-light mr-1" type="submit"><i class="mdi mdi-content-save-all"></i> Guardar</button>
                                    <button class="btn btn-danger btn-xs waves-effect" type="button"><i class="mdi mdi-close-box-outline"></i> Cancelar</button>
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
@endsection
