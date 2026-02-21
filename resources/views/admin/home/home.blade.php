@extends('Layouts.pantilla')
@section('title', 'Dashboard')
@section('css')
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/v/dt/dt-2.1.3/datatables.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" />

    <style>
        /* Forcing modal to take full screen */
        .modal-fullscreen {
            max-width: 100% !important;
            height: 100% !important;
            margin: 0;
        }

        .modal-dialog.modal-fullscreen {
            width: 100%;
            height: 100%;
            margin: 0;
        }

        .modal-content {
            height: 100%;
            border-radius: 0;
        }

        .modal-body {
            overflow-y: auto;
            height: calc(100% - 56px - 56px);
            /* Adjust for header and footer height */
        }
    </style>

@endsection
@section('contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="animate__animated animate__jackInTheBox">
                        <i class="fas fa-store-alt"> Producto Existente</i>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Producto</li>
                    </ol>
                </div>
            </div>
        </div>

    </section>

    <section>
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Informes</h3>
                </div>
                <div class="animate__animated  animate__fadeInDown card-body table-responsive">
                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-12">
                            <a href="{{ route('mas_consulta') }}" class="info-box-link" title="Ver mas Informacion">
                                <div class="info-box">
                                    <span class="info-box-icon bg-info">
                                        <i class="fab fa-sellsy"></i>
                                    </span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Venta Del Dia Por Vendedor</span>
                                        <span id="venta_dia_vendedor" class="info-box-number"></span>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-3 col-sm-6 col-12">
                            <a href="{{ route('mas_consulta') }}" class="info-box-link">
                                <div class="info-box">
                                    <span class="info-box-icon bg-success"><i class="fas fa-shopping-bag"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Venta Diria</span>
                                        <span id="venta_diaria" class="info-box-number"></span>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-3 col-sm-6 col-12">
                            <a href="{{ route('mas_consulta') }}" class="info-box-link">
                                <div class="info-box">
                                    <span class="info-box-icon bg-warning"> <i class="fas fa-calendar-alt"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Venta Mensual</span>
                                        <span id="venta_mensual" class="info-box-number">0</span>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-3 col-sm-6 col-12">
                            <a href="{{ route('mas_consulta') }}" class="info-box-link">
                                <div class="info-box">
                                    <span class="info-box-icon bg-danger">
                                        <i class="fas fa-chart-bar"></i>
                                    </span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Venta Anual</span>
                                        <span id="venta_anual" class="info-box-number">0</span>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-3 col-sm-6 col-12">
                            <a href="{{ route('mas_consulta') }}" class="info-box-link">
                                <div class="info-box">
                                    <span class="info-box-icon bg-secondary">
                                        <i class="fas fa-wallet"></i>
                                    </span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Ganancia Mensual</span>
                                        <span id="ganancia_mensual" class="info-box-number">0</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-footer">

                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container-fluid">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-exclamation-triangle"> Productos Críticos</i> </h3>
                </div>
                <div class="card-body  table-responsive">
                    <table id="lote" class="animate__animated  animate__fadeInDown table table-hover text-nowrap">
                        <thead class="table-warning">
                            <tr>
                                <th>Cod</th>
                                <th>Producto</th>
                                <th>Stock</th>
                                <th>Estado</th>
                                <th>Laboratorio</th>
                                <th>Presentacion</th>
                                <th>Proveedor</th>
                                <th>Mes</th>
                                <th>Dias</th>
                                <th>Hora</th>
                            </tr>
                        </thead>
                        <tbody id="lotes" class="table-active">

                        </tbody>
                    </table>
                </div>
                <div class="card-footer">

                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/v/dt/dt-2.1.3/datatables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <script>
        var urlBuscarProducto = "{{ route('buscar_productos') }}";
        var urlLoteRiesgo = "{{ route('lotes_riesgo') }}";
    </script>

    <script>
        $(document).ready(function() {

            mostrar_consulta();

            function formatoMoneda(valor) {
                return 'S/. ' + Number(valor).toLocaleString('es-PE', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            }

            function mostrar_consulta() {
                var url = "{{ route('ver_consulta') }}";

                $.post(url, {
                    _token: '{{ csrf_token() }}'
                }, (response) => {

                    if (typeof response === 'object') {
                        $('#venta_dia_vendedor').html(formatoMoneda(response.venta_dia_vendedor));
                        $('#venta_diaria').html(formatoMoneda(response.venta_diaria));
                        $('#venta_mensual').html(formatoMoneda(response.venta_mensual));
                        $('#venta_anual').html(formatoMoneda(response.venta_anual));
                        $('#ganancia_mensual').html(formatoMoneda(response.ganancia_mensual));
                    }

                });
            }

        });
    </script>


    <script src="{{ asset('js/lote.js') }}"></script>










@endsection
