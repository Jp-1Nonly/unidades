@extends('layout.app')

@section('content')
    <?php use Carbon\Carbon; ?>
    <main>
        <div class="container-fluid px-4">
            <h5 class="mt-4">Nuevo Pedido</h5>
            <ol class="breadcrumb mb-4">
              
                <li class="breadcrumb-item active">Agregar cantidades</li>
            </ol>
        </div>

        <div class="card mb-1">
            <div class="card-body">
                <div class="text-left mt-1">
                    <a href="{{ route('pedidos.index') }}" class="btn btn-primary btn-sm">Ver Lista de Pedidos</a>
                    <a href="{{ url('/productos') }}" class="btn btn-primary btn-sm">Agregar Productos</a>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fa-solid fa-utensils purple_color2"></i>
                Productos seleccionados
            </div>

        </div>
    </main>
@endsection
