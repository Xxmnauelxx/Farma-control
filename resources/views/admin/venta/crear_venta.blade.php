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
                        <i class="fas fa-store-alt"> Producto existente para venta</i>
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

