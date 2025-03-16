@extends('Layouts.pantilla')
@section('title', 'Ventas')
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
                    <h1 class="animate__animated animate__shakeY">
                        <i class="fas fa-coins"> Movimientos</i>
                    </h1>
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
                                        <span id="venta_dia_vendedor" class="info-box-number">1,410</span>
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
                                        <span id="venta_diaria" class="info-box-number">410</span>
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
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Listas de Venta Realizadas</h3>

                </div>
                <div class="card-body table-responsive">
                    <table id="tabla_venta" class="display table  table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Codigo</th>
                                <th>Fecha</th>
                                <th>Cliente</th>
                                <th>Indent</th>
                                <th>Total</th>
                                <th>Vendedor</th>
                                <th>Estado</th>
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

    <div class="modal fade" id="vista_venta">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header badge badge-success">
                    <h5 class="modal-title" id="exampleModalLabel">Detalles de Venta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="codigo_venta">Codigo Venta: </label>
                        <span id="codigo_venta"></span>
                    </div>
                    <div class="form-group">
                        <label for="fecha">Fecha: </label>
                        <span id="fecha"></span>
                    </div>
                    <div class="form-group">
                        <label for="cliente">Cliente: </label>
                        <span id="cliente"></span>
                    </div>
                    <div class="form-group">
                        <label for="dni">DNI: </label>
                        <span id="dni"></span>
                    </div>
                    <div class="form-group">
                        <label for="vendedor">Vendedor: </label>
                        <span id="vendedor"></span>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover  text-nowrap">
                            <thead class="table-success">
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>Producto</th>
                                <th>Concentracion</th>
                                <th>Adicional</th>
                                <th>Laboratorio</th>
                                <th>presentacion</th>
                                <th>Tipo</th>
                                <th>Subtotal</th>
                            </thead>

                            <tbody class="table-warning" id="registro">

                            </tbody>
                        </table>
                    </div>

                    <div class="float-right input-group-append">
                        <h3 class="mr-1">Total: </h3>
                        <h3 class="mr-1" id="total"></h3>
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
        $(document).ready(function() {
            mostrar_consulta();
            listar_ventas();
            var datatable;

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

            function listar_ventas() {
                var url = "{{ route('listar_ventas') }}";

                // Inicializar DataTable
                datatable = $('#tabla_venta').DataTable({
                    "ajax": {
                        "url": url,
                        "method": "POST",
                        "data": function(d) {
                            d._token = "{{ csrf_token() }}"; // Enviar CSRF token
                        },
                        "dataSrc": function(json) {
                            if (!json.data) {
                                console.error("Error: La respuesta no contiene la propiedad 'data'.",
                                    json);
                                return [];
                            }
                            return json.data;
                        }
                    },
                    "columns": [

                        {
                            "data": "codigo",
                            "className": "text-center", // Centrar el código

                        }, // Columna para el código (debe ser 'codigo' en el JSON)
                        {
                            "data": "fecha",
                            "render": function(data, type, row) {
                                // Formatear la fecha a 'YYYY-MM-DD'
                                if (data) {
                                    var date = new Date(data);
                                    var formattedDate = date.toISOString().split('T')[
                                        0]; // Extrae solo la fecha
                                    return formattedDate;
                                }
                                return ''; // Si no hay fecha, retorna una cadena vacía
                            }
                        }, // Columna para la fecha
                        {
                            "data": "cliente"
                        }, // Columna para el nombre del cliente
                        {
                            "data": "dni"
                        }, // Columna para el DNI del cliente
                        {
                            "data": "total",
                            "className": "text-center" // Centrar el código
                        }, // Columna para el total
                        {
                            "data": "vendedor"
                        }, // Columna para el nombre del vendedor
                        {
                            data: 'estado',
                            render: function(data, type, row) {
                                // Verificamos si el estado es 'facturado' y le asignamos el badge verde
                                if (data === 'Facturado') {
                                    return '<span class="badge bg-success">' + data + '</span>';
                                } else {
                                    return '<span class="badge bg-danger">' + data + '</span>';
                                }
                            }
                        },
                        {
                            data: null,
                            defaultContent: `
                <button class="imprimir btn btn-success">
                    <i class="fas fa-print"></i>
                </button>
                <button class="ver btn btn-primary" type="button" data-toggle="modal" data-target="#vista_venta">
                    <i class="fas fa-search"></i>
                </button>
                <button class="borrar btn btn-danger">
                    <i class="fas fa-window-close"></i>
                </button>
            `,
                            render: function(data, type, row) {
                                // Si el estado de la venta es cancelado, deshabilitamos el botón de eliminar
                                if (row.estado === 'cancelado') {
                                    return `
                        <button class="imprimir btn btn-success">
                            <i class="fas fa-print"></i>
                        </button>
                        <button class="ver btn btn-primary" type="button" data-toggle="modal" data-target="#vista_venta">
                            <i class="fas fa-search"></i>
                        </button>
                        <button class="borrar btn btn-danger" disabled>
                            <i class="fas fa-window-close"></i>
                        </button>
                    `;
                                }
                                return `
                    <button class="imprimir btn btn-success">
                        <i class="fas fa-print"></i>
                    </button>
                    <button class="ver btn btn-primary" type="button" data-toggle="modal" data-target="#vista_venta">
                        <i class="fas fa-search"></i>
                    </button>
                    <button class="borrar btn btn-danger">
                        <i class="fas fa-window-close"></i>
                    </button>
                    `;
                            }
                        }
                    ],
                    "destroy": true
                });
            }

            // imprimir
            $('#tabla_venta').on('click', '.imprimir', function() {
                let datos = datatable.row($(this).parents()).data();
                let id = datos.codigo;
                let url = "{{ route('imprimir_venta', ['id' => ':id']) }}";
                url = url.replace(':id', id); // Reemplaza el placeholder en la URL con el código de venta

                window.open(url, '_blank'); // Abre la URL en una nueva pestaña
            })

            $('#tabla_venta').on('click', '.ver', function() {
                let datos = datatable.row($(this).parents()).data();
                let id = datos.codigo;
                let url = "{{ route('ver_venta', ['id' => ':id']) }}";
                url = url.replace(':id', id);

                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(response) {
                        console.log(response);

                        // Llenar los datos en el modal
                        $('#codigo_venta').text(response.venta.id);
                        $('#fecha').text(response.venta.fecha);
                        $('#cliente').text(response.venta.cliente ? response.venta.cliente :
                            'N/D');
                        $('#dni').text(response.venta.dni ? response.venta.dni : 'N/D');

                        $('#vendedor').text(response.venta.vendedor);

                        // Llenar la tabla de detalles de venta
                        let registroHtml = '';
                        response.detalles.forEach(function(detalle) {
                            registroHtml += `
                    <tr>
                        <td>${detalle.cantidad}</td>
                        <td>${detalle.precio}</td>
                        <td>${detalle.producto}</td>
                        <td>${detalle.concentracion}</td>
                        <td>${detalle.adicional}</td>
                        <td>${detalle.laboratorio}</td>
                        <td>${detalle.presentacion}</td>
                        <td>${detalle.tipo}</td>
                        <td>${detalle.subtotal}</td>
                    </tr>
                `;
                        });
                        $('#registro').html(registroHtml);

                        // Mostrar el total de la venta
                        $('#total').text(response.venta.total);

                        // Abrir el modal
                        $('#vista_venta').modal('show');
                    },
                    error: function(error) {
                        console.log('Error al obtener la venta:', error);
                    }
                });
            });

            // Evento de cierre del modal
            $('#vista_venta').on('hidden.bs.modal', function() {
                // Limpiar el contenido al cerrar el modal
                $('#codigo_venta').text('');
                $('#fecha').text('');
                $('#cliente').text('');
                $('#dni').text('');
                $('#vendedor').text('');
                $('#registro').html('');
                $('#total').text('');

                // Asegurarse de que el atributo aria-hidden se maneje correctamente
                $(this).removeAttr('aria-hidden'); // Eliminar el aria-hidden al cerrarse
                $('body').removeClass('modal-open'); // Eliminar la clase modal-open
                $('.modal-backdrop').remove(); // Eliminar el fondo del modal
            });

            $('#tabla_venta').on('click', '.borrar', function() {
                let datos = datatable.row($(this).parents()).data();
                let id = datos.codigo;
                var url = "{{ route('borrar_venta', ['id' => ':id']) }}".replace(':id', id);

                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success m-1',
                        cancelButton: 'btn btn-danger m-1',
                    },
                    buttonsStyling: false
                });

                swalWithBootstrapButtons.fire({
                    title: '¿Está seguro de eliminar la venta ' + id + '?',
                    text: "¡No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'No, cancelar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'POST', // Si Laravel tiene protección CSRF, usar DELETE
                            data: {
                                _token: "{{ csrf_token() }}" // Se agrega el token CSRF
                            },
                            success: function(response) {
                                console.log("Respuesta del servidor:",
                                    response); // Verificar qué llega

                                if (response.status === 'cancelled') {
                                    swalWithBootstrapButtons.fire(
                                        'Eliminado!',
                                        'La Venta: ' + id + ' Ha Sido Eliminada.',
                                        'success'
                                    );
                                    listar_ventas();
                                } else if (response.status === 'nodeltete') {
                                    swalWithBootstrapButtons.fire(
                                        'No Eliminado',
                                        response
                                        .message, // Usar el mensaje que viene del backend
                                        'error'
                                    );
                                } else {
                                    swalWithBootstrapButtons.fire(
                                        'Error',
                                        'Ocurrió un problema al eliminar la venta.',
                                        'error'
                                    );
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error("Error en AJAX:", xhr.responseText);
                                let response = JSON.parse(xhr.responseText);

                                swalWithBootstrapButtons.fire(
                                    'Error',
                                    response.message ||
                                    'Error desconocido al eliminar la venta.',
                                    'error'
                                );
                            }

                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        swalWithBootstrapButtons.fire(
                            'Cancelado',
                            'La venta no fue eliminada :)',
                            'error'
                        );
                    }
                });
            });


        });
    </script>
@endsection
