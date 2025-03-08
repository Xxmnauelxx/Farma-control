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

    <section>
        <div class="container-fluid">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Buscar Productos</h3>
                    <div class="input-group">
                        <input id="busquedaProductos" type="text" class="form-control float-left"
                            placeholder="Ingrese nombre del producto">
                        <div class="input-group-append">
                            <button class="btn btn-secondary">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div id="productos" class="row d-flex align-items-stretch">

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="modalcompra" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header badge badge-success">
                    <h5 class="modal-title" id="exampleModalLabel">Realizar Venta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <header class="text-center mb-3">
                        <!-- Logo -->
                        <div class="logo_cp mb-3">
                            <img src="../img/logo.png" class="img-fluid" alt="Logo" width="100" height="100">
                        </div>

                        <!-- Nombre de la farmacia -->
                        <h1 class="titulo_cp mb-4">SOLICITUD DE VENTA</h1>

                        <!-- Datos -->
                        <div class="datos_cp">
                            <!-- Cliente -->
                            <div class="form-group row">
                                <label for="cliente" class="col-form-label col-md-2">Cliente: </label>
                                <div class="col-md-10">
                                    <select id="cliente" class="form-control select2" style="width:100%"></select>
                                </div>
                            </div>

                            <!-- Vendedor -->
                            <div class="form-group row">
                                <label for="vendedor" class="col-form-label col-md-2">Vendedor: </label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" id="vendedor" value="{{ $nombre }}"
                                        readonly>
                                </div>
                            </div>
                        </div>
                    </header>

                    <button class="btn btn-success mb-2" id="act">Actualizar</button>

                    <div id="cp" class="card-body table-responsive">
                        <table class="compra display table table-hover text-nowrap " id="tablacompra">
                            <thead class="table-success">
                                <tr>
                                    <th>Nombre</th>
                                    <th>Stock</th>
                                    <th>Precio</th>
                                    <th>Concentración</th>
                                    <th>Adicional</th>
                                    <th>Laboratorio</th>
                                    <th>Presentación</th>
                                    <th>Cantidad</th>
                                    <th>Sub Total</th>
                                    <th>Eliminar</th>
                                </tr>
                            </thead>
                            <tbody id="listacompra" class="table-active">
                                <!-- Aquí se cargarán las filas dinámicamente -->
                            </tbody>
                        </table>


                        <div class="row">
                            <div class="col-md-4">
                                <div class="card card-default">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            <i class="fas fa-dollar-sign"></i>
                                            Calculo 1
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="info-box mb-3 bg-warning p-0">
                                            <span class="info-box-icon"><i class="fas fa-tag"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text text-left ">SUB TOTAL</span>
                                                <span class="info-box-number" id="subtotal">10</span>
                                            </div>
                                        </div>
                                        <div class="info-box mb-3 bg-warning">
                                            <span class="info-box-icon"><i class="fas fa-tag"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text text-left ">IGV</span>
                                                <span class="info-box-number"id="con_igv">2</span>
                                            </div>
                                        </div>
                                        <div class="info-box mb-3 bg-info">
                                            <span class="info-box-icon"><i class="fas fa-tag"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text text-left ">SIN DESCUENTO</span>
                                                <span class="info-box-number" id="total_sin_descuento">12</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card card-default">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            <i class="fas fa-bullhorn"></i>
                                            Calculo 2
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="info-box mb-3 bg-danger">
                                            <span class="info-box-icon"><i class="fas fa-comment-dollar"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text text-left ">DESCUENTO</span>
                                                <input id="descuento"type="number" min="1"
                                                    placeholder="Ingrese descuento" class="form-control">
                                            </div>
                                        </div>
                                        <div class="info-box mb-3 bg-info">
                                            <span class="info-box-icon"><i class="ion ion-ios-cart-outline"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text text-left ">TOTAL</span>
                                                <span class="info-box-number" id="total">12</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card card-default">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            <i class="fas fa-cash-register"></i>
                                            Cambio
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="info-box mb-3 bg-success">
                                            <span class="info-box-icon"><i class="fas fa-money-bill-alt"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text text-left ">INGRESO</span>
                                                <input type="number" id="pago" min="1"
                                                    placeholder="Ingresa Dinero" class="form-control">

                                            </div>
                                        </div>
                                        <div class="info-box mb-3 bg-info">
                                            <span class="info-box-icon"><i class="fas fa-money-bill-wave"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text text-left ">VUELTO</span>
                                                <span class="info-box-number" id="vuelto">3</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row justify-content-between w-100">
                        <div class="col-md-3 w-100">
                            <button onclick="cerrarModalCompra()" class="btn btn-primary btn-block">Seguir
                                comprando</button>
                        </div>
                        <div class="col-md-9 w-100">
                            <a href="#" class="btn btn-success btn-block" id="procesar-compra">Realizar compra</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
        var rutaBuscarProdCompra = "{{ route('proceso_compra') }}";
        var rutaProdCompra = "{{ route('buscar_prod', ['id' => ':id']) }}";
        var rutaProdComprabuscar = "{{ route('buscar_prod_compra') }}";
        
        var home = "{{ route('home') }}";
        var CrearVenta = "{{ route('enviar_venta') }}";
    </script>

    <script src="{{ asset('js/carrito.js') }}"></script>






@endsection
