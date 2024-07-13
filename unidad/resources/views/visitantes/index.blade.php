@extends('layout.app')

@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title">Visitantes</h4>
            <div class="page-title-right">
                <ol class="breadcrumb p-0 m-0">
                    <li class="breadcrumb-item"><a href="#">Tablero</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('visitantes.create') }}">visitantes</a></li>
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
               
                <a href="{{ route('visitantes.create') }}" class="btn btn-warning btn-xs"><i class="mdi mdi-account-multiple"></i> Nuevo</a>
            </div>
            
    
            <div class="card-body">

                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>Documento</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Descripción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($visitantes as $visitante)
                        <tr>
                            <td>{{ $visitante['documento_visitante'] }}</td>
                            <td>{{ $visitante['nombre_visitante'] }}</td>
                            <td>{{ $visitante['apellido_visitante'] }}</td>
                            <td>{{ $visitante['descripcion'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>

</div>
@endsection