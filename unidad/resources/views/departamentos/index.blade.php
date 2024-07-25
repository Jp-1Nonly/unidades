@extends('layout.app')

@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title">Departamentos</h4>
            <div class="page-title-right">
                <ol class="breadcrumb p-0 m-0">
                    <li class="breadcrumb-item"><a href="#">Tablero</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('departamentos.create') }}">Departamentos</a></li>
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
               
                <a href="{{ route('departamentos.create') }}" class="btn btn-danger btn-xs"><i class="mdi mdi-account-multiple"></i> Nuevo</a>
            </div>
            
    
            <div class="card-body">

                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($deptos as $depto)
                        <tr>
                            <td>{{ $depto['id'] }}</td>
                            <td>{{ $depto['nombre_dpto'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>

</div>
@endsection