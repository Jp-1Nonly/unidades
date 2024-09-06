@extends('layout.app')

@section('content')
    <?php use Carbon\Carbon;
    ?>
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

            @if (session('cart'))
                <div class="card-body">
                    <div class="card-datatable table-responsive">
                        <table id="datatablesSimple" class="datatables-basic table border-top">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Item</th>
                                    <th>Producto</th>
                                    <th>Medida</th>
                                    <th>Precio Unitario</th>
                                    <th>Cantidad</th>
                                    <th>Total</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    // Ordena la colección de carrito por clave
                                    $cart = collect(session('cart'))->sortBy(function ($item, $key) {
                                        return $key;
                                    });
                                @endphp

                                @foreach ($cart as $key => $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td> <!-- Muestra el número del ítem -->
                                        <td>{{ $item['nombre'] }}</td>
                                        <td>{{ $item['medida'] }}</td>
                                        <td>${{ number_format($item['precio'], 0, ',', '.') }}</td>
                                        <td>
                                            <form action="{{ url('/update-cart', $key) }}" method="post">
                                                @csrf
                                                @method('put')
                                                <div class="input-group">
                                                    <input type="number" name="cantidad" value="{{ $item['cantidad'] }}"
                                                        min="1" class="form-control" style="font-size: 12px;"
                                                        step="0.5">
                                                    <div class="input-group-append">
                                                        <button type="submit" class="btn btn-primary btn-sm"><i
                                                                class="fa-solid fa-plus-minus"></i></button>
                                                    </div>
                                                </div>
                                            </form>
                                        </td>
                                        <td>${{ number_format($item['precio'] * $item['cantidad'], 0, ',', '.') }}</td>
                                        <td>
                                            <form id="removeItemForm{{ $key }}"
                                                action="{{ route('remove-item', ['id' => $key]) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"><i
                                                        class="fa-regular fa-trash-can"></i></button>
                                            </form>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <p>
                        @php
                            $totalRubro = session('totalRubro');
                            $totalAdicion = session('totalAdicion');
                            $totalPresupuesto = 0;
                            $totalSaldo = $totalRubro + $totalAdicion;
                            $saldoGlobal = 0;
                            echo 'Saldo del contrato ' . "$ " . number_format($totalSaldo, 0, ',', '.');
                        @endphp

                    </p>
                    <form id="procesarPedidoForm" action="{{ url('/procesar-pedido') }}" method="post">

                        @csrf
                        <div class="mt-4">
                            <p>Total de todos los productos:
                                ${{ number_format(
                                    array_sum(
                                        array_map(function ($item) {
                                            return $item['precio'] * $item['cantidad'];
                                        }, session('cart')),
                                    ),
                                    0,
                                    ',',
                                    '.',
                                ) }}
                            </p>
                            <p>
                                @php
                                    $saldoGlobal =
                                        $totalSaldo -
                                        array_sum(
                                            array_map(function ($item) {
                                                return $item['precio'] * $item['cantidad'];
                                            }, session('cart')),
                                        );

                                    $saldoGlobalF = number_format($saldoGlobal, 0, ',', '.');
                                @endphp
                                @if ($saldoGlobal < 0)
                                    <div class="alert alert-danger mt-4" role="alert">
                                        Saldo con este pedido: ${{ $saldoGlobalF }}
                                    </div>
                                @else
                                    <p>Saldo con este pedido: ${{ $saldoGlobalF }}</p>
                                @endif
                            </p>
                            <p>
                                @if ($saldoGlobal < 0)
                                    <div class="alert alert-danger mt-4" role="alert">
                                        No es posible realizar el pedido por falta de saldo.
                                    </div>
                                @endif

                            </p>
                           

                        </div>
                       

                        <div class="mt-4">
                            <h6>Selecciona ficha</h6>
                            <select name="ficha" id="ficha" class="form-control">
                                <?php $f_fin_seleccionado = null; ?> <!-- Inicializa la variable fuera del bucle -->
                                @foreach ($ficha as $fichas)
                                    <option value="{{ $fichas['id'] }}">{{ $fichas['ficha'] }} - {{ $fichas['nombre'] }} - {{ $fichas['f_fin'] }}</option>
                                    <?php $f_fin_seleccionado = $fichas['f_fin']; ?> <!-- Actualiza la variable en cada iteración -->
                                @endforeach
                            </select>
                        </div>
                        
                        <?php
                        // Trabaja con $f_fin_seleccionado fuera del bucle
                        if ($f_fin_seleccionado !== null) {
                            // Crear objeto Carbon a partir del formato
                            $fechaCarbon = \Carbon\Carbon::createFromFormat('Y-m-d', $f_fin_seleccionado);
                            
                            // Calcular el número de días entre la fecha actual y la fecha seleccionada
                            $dias = $fechaCarbon->diffInDays(\Carbon\Carbon::now());
                            
                            // Verificar si la fecha fue parseada correctamente
                            if ($fechaCarbon === false) {
                                echo 'Error al analizar la fecha.';
                            } else {
                                echo 'Número de días: ' . $dias;
                            }
                        }
                        ?>
                        
                        


                        <div class="mt-4">
                            <h6>Selecciona Instructor</h6>
                            <select name="profesor" id="profesor" class="form-control">
                                @foreach ($profesor as $profesores)
                                    <option value="{{ $profesores['id'] }}">{{ $profesores['nombre'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mt-4">
                            <h6>Selecciona Área</h6>
                            <select name="area" id="area" class="form-control">
                                @foreach ($areas as $area)
                                    <option value="{{ $area['id'] }}">{{ $area['nombre'] }} -
                                        {{ $area['coordinador'] }}</option>
                                @endforeach
                            </select>
                        </div>


                        @if ($saldoGlobal >= 0)
                            <div class="mt-4">
                                <button type="submit" class="btn btn-success btn-sm"><i
                                        class="fa-regular fa-paper-plane"></i> Realizar Pedido</button>
                            </div>
                        @endif

                    </form>
                </div>
            @else
                <div class="card-body">
                    <div class="alert alert-danger mt-4" role="alert">
                        El carrito está vacío
                    </div>
                </div>
            @endif
        </div>
    </main>

    <script>
        // Espera a que el DOM esté completamente cargado
        document.addEventListener('DOMContentLoaded', function() {
            // Selecciona el formulario por su ID
            const form = document.getElementById('procesarPedidoForm');

            // Agrega un event listener para el evento submit del formulario
            form.addEventListener('submit', function(event) {
                // Evita que el formulario se envíe de manera predeterminada
                event.preventDefault();

                // Envía el formulario utilizando Fetch API o AJAX
                fetch(form.action, {
                        method: form.method,
                        body: new FormData(form)
                    })
                    .then(response => {
                        if (response.ok) {
                            // Muestra el Sweet Alert cuando la respuesta es exitosa
                            Swal.fire(
                                '¡Pedido realizado exitosamente!',
                                '',
                                'success'
                            ).then(() => {
                                // Redirige al usuario a la URL "/" después de cerrar el Sweet Alert
                                window.location.href = "/";
                            });
                        } else {
                            // Maneja errores aquí si es necesario
                        }
                    })
                    .catch(error => {
                        console.error('Error al enviar el formulario:', error);
                    });
            });
        });
    </script>



@endsection
