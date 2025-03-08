@extends('Layouts.pantilla')
@section('title', 'Cliente')
@section('css')
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/v/dt/dt-2.1.3/datatables.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" />
    <style>
        .info-box-link {
            text-decoration: none;
            /* Elimina el subrayado del enlace */
            color: inherit;
            /* Mantiene el color original del texto */
            display: block;
            /* Hace que todo el div sea clickeable */
        }
    </style>
@endsection
@section('contenido')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="animate__animated animate__shakeY">Gestion Venta</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="adm_catalogo.php">Home</a></li>
                        <li class="breadcrumb-item active">Gestion Venta</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Consultas</h3>
                </div>
                <div class="animate__animated  animate__fadeInDown card-body table-responsive">
                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-12">
                            <a href="adm_mas_consulta.php" class="info-box-link" title="Ver mas Informacion">
                                <div class="info-box">
                                    <span class="info-box-icon bg-info">
                                        <i class="fab fa-sellsy"></i>
                                    </span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Venta Del Dia Por Vendedor</span>
                                        <span id="venta_dia_vendedor" class="info-box-number">1,410</span>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-3 col-sm-6 col-12">
                            <a href="tu_enlace_aqui.php" class="info-box-link">
                                <div class="info-box">
                                    <span class="info-box-icon bg-success"><i class="fas fa-shopping-bag"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Venta Diria</span>
                                        <span id="venta_diaria" class="info-box-number">410</span>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-3 col-sm-6 col-12">
                            <a href="tu_enlace_aqui.php" class="info-box-link">
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
                            <a href="tu_enlace_aqui.php" class="info-box-link">
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
                            <a href="tu_enlace_aqui.php" class="info-box-link">
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
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Buscar Venta</h3>

                </div>
                <div class="card-body table-responsive">
                    <table id="tabla_venta" class="display table table-hover text-nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>Codigo</th>
                                <th>Fecha</th>
                                <th>Cliente</th>
                                <th>DNI</th>
                                <th>Total</th>
                                <th>Vendedor</th>
                                <th>Accion</th>
                            </tr>
                        </thead>
                        <tbody>

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
        $(document).ready(function() {
            mostrar_consulta();
            function mostrar_consulta() {
               var url = "{{ route('ver_consulta') }}";
                $.post(url, {
                    _token: '{{ csrf_token() }}'
                }, (response) => {
                    console.log(response);

                    if (typeof response === 'object') {
                    $('#venta_dia_vendedor').html((response.venta_dia_vendedor * 1).toFixed(2));
                    $('#venta_diaria').html((response.venta_diaria * 1).toFixed(2));
                    $('#venta_mensual').html((response.venta_mensual * 1).toFixed(2));
                    $('#venta_anual').html((response.venta_anual * 1).toFixed(2));
                    $('#ganancia_mensual').html((response.ganancia_mensual * 1).toFixed(2));
                }
                });
            }

        });
    </script>
@endsection
