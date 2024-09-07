<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Pedido N° {{ $pedido->id }} - Creado en {{ $pedido->created_at->format('Y-m-d') }}</title>
    <!-- PLUTO -->
    <link rel="icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link href="{{ asset('css2/styles.css') }}" rel="stylesheet" />
    <!-- bootstrap css -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
    <!-- site css -->
    <link rel="stylesheet" href="{{ asset('style.css') }}" />
    <!-- responsive css -->
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}" />
    <!-- color css -->
    <link rel="stylesheet" href="{{ asset('css/colors.css') }}" />
    <!-- select bootstrap -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap-select.css') }}" />
    <!-- scrollbar css -->
    <link rel="stylesheet" href="{{ asset('css/perfect-scrollbar.css') }}" />
    <!-- custom css -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/css-5.css') }}">
    <!--[if lt IE 9]> -->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.min.js"
        integrity="sha512-L0Shl7nXXzIlBSUUPpxrokqq4ojqgZFQczTYlGjzONGTDAcLremjwaWv5A+EDLnxhQzY5xUZPWLOLqYRkY0Cbw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        #sidebar {
            overflow-y: hidden;
            /* Oculta la barra de desplazamiento vertical */
        }
    </style>

</head>

<body class="dashboard dashboard_1">
    <div class="full_container">
        <div class="inner_container">
            <!-- Sidebar  -->
            <nav id="sidebar">
                <div class="sidebar_blog_1">
                    <div class="sidebar-header">
                        <div class="logo_section">
                            <a href="#"><img class="logo_icon img-responsive"
                                    src="{{ asset('images/logo/logo_icon.png') }}" alt="#" /></a>
                        </div>
                    </div>
                    <div class="sidebar_user_info">
                        <div class="icon_setting"></div>
                        <div class="user_profle_side">
                            <div class="user_img"><img class="img-responsive"
                                    src="{{ asset('images/layout_img/user_img.jpg') }}" alt="#" /></div>
                            <div class="user_info">
                                <h6>Economato</h6>
                                <p> <span class="online_animation"></span> Online</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sidebar_blog_2">
                    <h4>General</h4>
                    <ul class="list-unstyled components">
                        <li><a href="{{ route('home') }}"><i class="fa fa-dashboard yellow_color"></i> <span>
                                    Dashboard</span></a></li>
                        <li><a href="{{ route('pedidos.index') }}"><i class="fa-solid fa-receipt green_color"></i>
                                <span>Pedidos</span></a></li>
                        <li><a href="{{ route('productos.lista') }}"><i class="fa-solid fa-utensils purple_color2"></i>
                                <span>Productos</span></a></li>
                        <li><a href="{{ route('profesor.index') }}"><i
                                    class="fa-solid fa-person-chalkboard blue1_color"></i> <span>Instructores</span></a>
                        </li>
                        <li><a href="{{ route('areas.index') }}"><i class="fa fa-briefcase blue1_color"></i>
                                <span>Ejecución</span></a></li>

                        <li><a href="{{ route('datos.index') }}"><i class="fa fa-cog yellow_color"></i>
                                <span>Configurar</span></a></li>
                        <li><a href="contact.html"><i class="fa fa-paper-plane red_color"></i> <span>Créditos</span></a>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- end sidebar -->
            <!-- right content -->
            <div id="content">
                <!-- topbar -->
                <div class="topbar">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <div class="full">
                            <button type="button" id="sidebarCollapse" class="sidebar_toggle"><i
                                    class="fa fa-bars"></i></button>
                            <div class="logo_section"></div>
                            <div class="right_topbar">
                                <div class="icon_info">
                                    <ul class="user_profile_dd">
                                        <li>
                                            <a class="dropdown-toggle" data-toggle="dropdown"><img
                                                    class="img-responsive rounded-circle"
                                                    src="{{ asset('images/layout_img/user_img.jpg') }}"
                                                    alt

="#" /><span class="name_user">Economato</span></a>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="profile.html">My Profile</a>
                                                <a class="dropdown-item" href="settings.html">Settings</a>
                                                <a class="dropdown-item" href="help.html">Help</a>
                                                <a class="dropdown-item" href="#"><span>Log Out</span> <i
                                                        class="fa fa-sign-out"></i></a>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </nav>
                </div>
                <!-- end topbar -->
                <!-- dashboard inner -->
                <div class="midde_cont">
                    <div class="container-fluid">
                        <!-- ****** INICIA @yiild content ****** -->
                        <main>
                            <div class="container-fluid px-4">
                                <h5 class="mt-4">Pedidos</h5>
                                <ol class="breadcrumb mb-4">
                                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Exportar</li>
                                </ol>

                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fa-solid fa-utensils purple_color2"></i>
                                        Listado de productos - Pedido N° {{ $pedido->id }}
                                    </div>
                                    <br>
                                    <div class="card-body">
                                        <div class="card-datatable table-responsive">
                                            <table id="myTable" class="datatables-basic table border-top">
                                                <thead>
                                                    <tr>
                                                        <th>Item</th>
                                                        <th>Descripción</th>
                                                        <th>Medida</th>
                                                        <th>Cantidad</th>
                                                        <th>Precio Unitario</th>
                                                        <th>Precio Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $total = 0; ?>
                                                    @php
                                                        $detallesOrdenados = $pedido->detalles->sortBy('producto_id');
                                                    @endphp
                                                    @forelse ($pedido->detalles as $detalle)
                                                        <tr>
                                                            <td>{{ $detalle->producto_id }}</td>
                                                            <td>
                                                                @if ($detalle->producto)
                                                                    {{ $detalle->producto->nombre }}
                                                                @else
                                                                    Producto no disponible
                                                                @endif
                                                            </td>
                                                            <td>{{ optional($detalle->producto)->medida ?? 'N/A' }}
                                                            </td>
                                                            <td>{{ $detalle->cantidad }}</td>
                                                            <td>
                                                                @if ($detalle->producto)
                                                                    ${{ number_format($detalle->producto->precio, 0, '.', ',') }}
                                                                @else
                                                                    N/A
                                                                @endif
                                                            </td>
                                                            <td>${{ number_format($detalle->cantidad * $detalle->producto->precio, 0, '.', ',') }}
                                                            </td>
                                                        </tr>
                                                        <?php $total = $total + $detalle->cantidad * $detalle->producto->precio; ?>
                                                    @empty
                                                        <tr>
                                                            <td colspan="6">No hay detalles disponibles</td>
                                                        </tr>
                                                    @endforelse

                                                    <tr>
                                                        <td style="color: white;">701</td>
                                                     
                                                     
                                                        <td>Area</td>
                                                        <td>Instructor</td>
                                                        <td>Observaciones</td>
                                                    </tr>

                                                    <tr>
                                                        <td style="color: white;">702</td>
                                                    
                                                        <td>{{ $pedido->area->nombre }}</td>
                                                        <td>{{ $pedido->profesor->nombre }}</td>
                                                        <td>{{ $pedido->observaciones }}</td>
                                                    </tr>
                                                    
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="5" style="text-align: right;">TOTAL:</td>
                                                        <td><strong>$<?php echo number_format($total, 0, '.', ','); ?></strong></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- CIERRA yield content -->
                            </div>
                        </main>
                    </div>
                    <!-- Cierra Container -->
                    <!-- footer -->
                    <div class="container-fluid">
                        <div class="footer">
                            <div class="card-body">
                                Desarrollado por Juan Pablo Cañas Marín + Oscar Cañas | SENA - CESGE | Copyright ©
                                2024
                            </div>
                        </div>
                    </div>
                    <!-- end dashboard inner -->
                </div><!-- end inner_contanier -->
            </div>
        </div>
    </div>
    <!-- jquery y bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous">
    </script>
    <!-- datatables con bootstrap -->
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap5.min.js"></script>
    <!-- Para usar los botones -->
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
    <!-- Para los estilos en Excel     -->
    <script src="https://cdn.jsdelivr.net/npm/datatables-buttons-excel-styles@1.1.1/js/buttons.html5.styles.min.js">
    </script>
    <script
        src="https://cdn.jsdelivr.net/npm/datatables-buttons-excel-styles@1.1.1/js/buttons.html5.styles.templates.min.js">
    </script>
    <script>
        $(document).ready(function() {
            $("#myTable").DataTable({
                dom: "Bfrtip",
                buttons: {
                    dom: {
                        button: {
                            className: 'btn'
                        }
                    },
                    buttons: [{
                        //definimos estilos del boton de excel
                        extend: "excel",
                        text: 'Exportar a Excel',
                        className: 'btn btn-outline-success',
                        excelStyles: {
                            "template": [
                                "blue_medium",
                                "header_green",
                                "title_medium"
                            ]
                        },
                    }]
                }
            });
        });
    </script>
</body>

</html>