@extends('layout.app')

@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title">Nuevo departamento</h4>
            <div class="page-title-right">
                <ol class="breadcrumb p-0 m-0">
                    <li class="breadcrumb-item"><a href="#">Tablero</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('departamentos.index') }}">Departamentos</a></li>
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
                    <form action="{{ route('departamentos.store') }}"
                        method="POST" class="cmxform form-horizontal tasi-form" id="commentForm" novalidate="novalidate">
                        @csrf
                        <div class="form-group row">
                            <label for="nombre_dpto" class="col-form-label col-lg-2">Nombre</label>
                            <div class="col-lg-4">
                                <input class="form-control" id="nombre_dpto" type="text" name="nombre_dpto"
                                    required="" aria-required="true">
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="lider_id" class="col-form-label col-lg-2">Encargado</label>
                            <div class="col-lg-4">
                                <input class="form-control" type="number" id="lider_id" name="lider_id"
                                    required="" aria-required="true">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="offset-lg-2 col-lg-10">
                                <button class="btn btn-success btn-xs waves-effect waves-light mr-1"
                                    type="submit"><i class="mdi mdi-content-save-all"></i> Guardar</button>
                                <button class="btn btn-danger btn-xs waves-effect" type="button" onclick="window.history.back();"><i class="mdi mdi-close-box-outline"></i> Cancelar</button>
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
