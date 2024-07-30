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
                    <h3 class="card-title">Ingresar datos del nuevo residente</h3>
                </div>
                <div class="card-body">
                    <div class="form">
                        <form action="{{ route('residentes.store') }}" method="POST" class="cmxform form-horizontal tasi-form" id="commentForm">
                            @csrf
                            <div class="row align-items-start">
                                <div class="col-lg-6">
                                    <div class="form-group row">
                                        <label for="documento" class="col-form-label col-lg-4">Documento</label>
                                        <div class="col-lg-8">
                                            <input class="form-control" id="documento" type="text" name="documento" placeholder="Ingrese número de documento" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="nombre" class="col-form-label col-lg-4">Nombre</label>
                                        <div class="col-lg-8">
                                            <input class="form-control" id="nombre" type="text" name="nombre" placeholder="Ingrese el nombre completo" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="apellido" class="col-form-label col-lg-4">Apellidos</label>
                                        <div class="col-lg-8">
                                            <input class="form-control" id="apellido" type="text" name="apellido" placeholder="Ingrese los apellidos" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="edad" class="col-form-label col-lg-4">Edad</label>
                                        <div class="col-lg-8">
                                            <input class="form-control" id="edad" type="number" name="edad" placeholder="Ingrese la edad" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="telefono" class="col-form-label col-lg-4">Celular</label>
                                        <div class="col-lg-8">
                                            <input class="form-control" id="telefono" type="tel" name="telefono" placeholder="Ingrese número celular">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group row">
                                        <label for="correo" class="col-form-label col-lg-4">Correo</label>
                                        <div class="col-lg-8">
                                            <input class="form-control" id="correo" type="email" name="correo" placeholder="Ingrese correo electrónico" >
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="apartamento" class="col-form-label col-lg-4">Apartamento</label>
                                        <div class="col-lg-8">
                                            <input class="form-control" id="apartamento" type="text" name="apartamento" placeholder="Ingrese número de apartamento" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="mascota" class="col-form-label col-lg-4">Mascota</label>
                                        <div class="col-lg-8">
                                            <input class="form-control" id="mascota" type="text" name="mascota" placeholder="Si no tiene dejar en blanco">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="condicion" class="col-form-label col-lg-4">Categoría</label>
                                        <div class="col-lg-8">
                                            <select class="form-control" id="condicion" name="condicion" required>
                                                <option value="Propietario">Propietario</option>
                                                <option value="Propietario residente">Propietario residente</option>
                                                <option value="Residente">Residente</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="discapacidad" class="col-form-label col-lg-4">Discapacidad</label>
                                        <div class="col-lg-8">
                                            <select class="form-control" id="discapacidad" name="discapacidad">
                                                <option value="Ninguna">Ninguna</option>
                                                <option value="Movilidad">Movilidad</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row mb-0">
                                <div class="offset-lg-2 col-lg-8 text-lg-center">
                                    <button class="btn btn-success btn-xs waves-effect waves-light mr-1" type="submit"><i class="mdi mdi-content-save-all"></i> Guardar</button>
                                    <button class="btn btn-danger btn-xs waves-effect" type="button" onclick="window.location='{{ route('residentes.index') }}'"><i class="mdi mdi-close-box-outline"></i> Cancelar</button>
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
@endsection
