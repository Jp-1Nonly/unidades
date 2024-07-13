@extends('layout.app')

@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title">Talento humano</h4>
            <div class="page-title-right">
                <ol class="breadcrumb p-0 m-0">
                    <li class="breadcrumb-item"><a href="#">Tablero</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('personas.create') }}">Personal</a></li>
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
               
                <a href="{{ route('personas.create') }}" class="btn btn-warning btn-xs"><i class="mdi mdi-account-multiple"></i> Nuevo</a>
            </div>
            
    
            <div class="card-body">

                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Correo</th>
                            <th>Fecha inicio</th>
                            <th>Cargo</th>
                            <th>Departamento</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($personas as $persona)
                        <tr>
                         
                            <td>{{ $persona['nombre_persona'] }}</td>
                            <td>{{ $persona['apellido'] }}</td>
                            <td>{{ $persona['correo'] }}</td>
                            <td>{{ \Carbon\Carbon::parse($persona['fecha_contratacion'])->format('d/m/Y') }}</td>
                            <td>{{ $persona['nombre_cargo'] }}</td>
                            <td>{{ $persona['nombre_dpto'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>

</div>
@endsection