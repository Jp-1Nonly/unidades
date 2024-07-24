    @extends('layout.app')

    @section('content')
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">Nuevo registro</h4>
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
                        <h3 class="card-title">Ingresar datos del nuevo colaborador</h3>
                    </div>
                    <div class="card-body">
                        <div class="form">
                            <form action="{{ route('personas.store') }}" method="POST" class="cmxform form-horizontal tasi-form" id="commentForm">
                                @csrf
                                <div class="row align-items-start">
                                    <div class="col-lg-6"> <!-- Columna izquierda -->
                                        <div class="form-group row">
                                            <label for="documento" class="col-form-label col-lg-4">Documento</label>
                                            <div class="col-lg-8">
                                                <input class="form-control" id="documento" type="text" name="documento" placeholder="Ingrese número de documento" aria-required="true" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="nombre_departamento" class="col-form-label col-lg-4">Nombre</label>
                                            <div class="col-lg-8">
                                                <input class="form-control" id="nombre_persona" type="text" name="nombre_persona" placeholder="Ingrese el nombre completo" aria-required="true" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="apellido" class="col-form-label col-lg-4">Apellidos</label>
                                            <div class="col-lg-8">
                                                <input class="form-control" id="apellido" type="text" name="apellido" placeholder="Ingrese los apellidos" aria-required="true" required>
                                            </div>
                                        </div> 
                                        <div class="form-group row">
                                            <label for="telefono" class="col-form-label col-lg-4">Celular</label>
                                            <div class="col-lg-8">
                                                <input class="form-control" id="telefono" type="tel" name="telefono" placeholder="Ingrese número celular" >
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="correo" class="col-form-label col-lg-4">Correo</label>
                                            <div class="col-lg-8">
                                                <input class="form-control" id="correo" type="email" name="correo" placeholder="Ingrese correo electrónico">
                                            </div>
                                        </div>                                  
                                    
                                    </div>
                                    
                                    <div class="col-lg-6"> <!-- Columna derecha -->
                                    
                                        <div class="form-group row">
                                            <label for="departamento" class="col-form-label col-lg-4">Departamento</label>
                                            <div class="col-lg-8">
                                                <select class="form-control" name="departamento_id" id="departamento">
                                                    <option value="" disabled selected>Elige un departamento</option>
                                                    @foreach ($dptos as $dpto)
                                                        <option value="{{ $dpto['id'] }}">{{ $dpto['nombre_dpto'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="tipo" class="col-form-label col-lg-4">Cargo</label>
                                            <div class="col-lg-8">
                                                <select class="form-control" name="cargo_id" id="tipo">
                                                    <option value="" disabled selected>Elige un cargo</option>
                                                    @foreach ($cargos as $cargo)
                                                        <option value="{{ $cargo['id'] }}">{{ $cargo['nombre_cargo'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="fecha_contratacion" class="col-form-label col-lg-4">Fecha inicio labores</label>
                                            <div class="col-lg-8">
                                                <input class="form-control" id="fecha_contratacion" type="date" name="fecha_contratacion" >
                                            </div>
                                        </div>
                                        
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
