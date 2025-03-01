@extends('Layouts.pantilla')
@section('title', 'Inventario')
@section('css')
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/v/dt/dt-2.1.3/datatables.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" />
@endsection
@section('contenido')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-solid fa-cubes"> Gestion Lote</i></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                        <li class="breadcrumb-item active"> Gestion Lote</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Buscar Lotes</h3>
                    <div class="input-group">
                        <input id="buscarlote" type="text" class="form-control float-left" placeholder="Ingrese Nombre Del Producto">
                       <div class="input-group-append">
                         <button class="btn btn-secondary">
                             <i class="fas fa-search"></i>
                         </button>
                       </div>
                    </div>
                </div>

                <div class="card-body">
                    <div id="lote" class="row d-flex align-items-stretch">

                    </div>
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
        // Esperamos a que el documento esté listo antes de ejecutar el código.
        $(document).ready(function() {
            $('.select2').select2();
            var funcion;
            // Llamamos a la función 'buscar_lote' al cargar la página para mostrar todos los lotes inicialmente.
            buscar_lotes();

            // Función para buscar productos usando la consulta proporcionada
            function buscar_lotes(consulta = '') {
                var url = "{{ route('buscar_lotes') }}";
                $.ajax({
                    type: "GET", // Método HTTP: GET
                    url: url, // URL del endpoint para buscar productos
                    data: {
                        consulta: consulta
                    }, // Pasamos la consulta de búsqueda al servidor
                    success: function(data) {
                        console.log(data)
                    },
                    error: function(xhr, status, error) {
                        // Si ocurre un error, mostramos los detalles en consola
                        console.error("Error details:");
                        console.error("Status: " + status);
                        console.error("Error: " + error);
                        console.error("Response Text: " + xhr.responseText);
                    }
                });
            }

            // Al escribir en el campo de búsqueda, llamamos a la función 'buscar_producto' para filtrar los productos
            $(document).on('keyup', '#buscarlote', function() {
                let valor = $(this).val(); // Obtenemos el valor del campo de búsqueda
                if (valor != '') {
                    buscar_lotes(valor); // Si hay un valor, buscamos productos que coincidan
                } else {
                    buscar_lotes(); // Si no hay valor, mostramos todos los productos
                }
            });








        });
    </script>



@endsection
