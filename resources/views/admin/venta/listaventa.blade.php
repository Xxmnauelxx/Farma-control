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
                    <h3 class="card-title">Listas de Venta Realizadas</h3>

                </div>
                <div class="card-body table-responsive">
                    <table id="tabla_venta" class="display table  table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Fecha</th>
                                <th>Cliente</th>
                                <th>Doc. Identifacion</th>
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
                                <th>Cantidad/Unidad</th>
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
                        <h3 class="mr-1">Total (S/.): </h3>
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
            listar_ventas();
            var datatable;

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
                    "destroy": true,
                    "language": espanol
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
                                <td>S/. ${detalle.precio}</td>
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


        let espanol = {
            "processing": "Procesando...",
            "lengthMenu": "Mostrar _MENU_ registros",
            "zeroRecords": "No se encontraron resultados",
            "emptyTable": "Ningún dato disponible en esta tabla",
            "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
            "search": "Buscar:",
            "infoThousands": ",",
            "loadingRecords": "No hay datos que Mostrar...",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            },
            "aria": {
                "sortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sortDescending": ": Activar para ordenar la columna de manera descendente"
            },
            "buttons": {
                "copy": "Copiar",
                "colvis": "Visibilidad",
                "collection": "Colección",
                "colvisRestore": "Restaurar visibilidad",
                "copyKeys": "Presione ctrl o u2318 + C para copiar los datos de la tabla al portapapeles del sistema. <br \/> <br \/> Para cancelar, haga clic en este mensaje o presione escape.",
                "copySuccess": {
                    "1": "Copiada 1 fila al portapapeles",
                    "_": "Copiadas %ds fila al portapapeles"
                },
                "copyTitle": "Copiar al portapapeles",
                "csv": "CSV",
                "excel": "Excel",
                "pageLength": {
                    "-1": "Mostrar todas las filas",
                    "_": "Mostrar %d filas"
                },
                "pdf": "PDF",
                "print": "Imprimir",
                "renameState": "Cambiar nombre",
                "updateState": "Actualizar",
                "createState": "Crear Estado",
                "removeAllStates": "Remover Estados",
                "removeState": "Remover",
                "savedStates": "Estados Guardados",
                "stateRestore": "Estado %d"
            },
            "autoFill": {
                "cancel": "Cancelar",
                "fill": "Rellene todas las celdas con <i>%d<\/i>",
                "fillHorizontal": "Rellenar celdas horizontalmente",
                "fillVertical": "Rellenar celdas verticalmentemente"
            },
            "decimal": ",",
            "searchBuilder": {
                "add": "Añadir condición",
                "button": {
                    "0": "Constructor de búsqueda",
                    "_": "Constructor de búsqueda (%d)"
                },
                "clearAll": "Borrar todo",
                "condition": "Condición",
                "conditions": {
                    "date": {
                        "after": "Despues",
                        "before": "Antes",
                        "between": "Entre",
                        "empty": "Vacío",
                        "equals": "Igual a",
                        "notBetween": "No entre",
                        "notEmpty": "No Vacio",
                        "not": "Diferente de"
                    },
                    "number": {
                        "between": "Entre",
                        "empty": "Vacio",
                        "equals": "Igual a",
                        "gt": "Mayor a",
                        "gte": "Mayor o igual a",
                        "lt": "Menor que",
                        "lte": "Menor o igual que",
                        "notBetween": "No entre",
                        "notEmpty": "No vacío",
                        "not": "Diferente de"
                    },
                    "string": {
                        "contains": "Contiene",
                        "empty": "Vacío",
                        "endsWith": "Termina en",
                        "equals": "Igual a",
                        "notEmpty": "No Vacio",
                        "startsWith": "Empieza con",
                        "not": "Diferente de",
                        "notContains": "No Contiene",
                        "notStarts": "No empieza con",
                        "notEnds": "No termina con"
                    },
                    "array": {
                        "not": "Diferente de",
                        "equals": "Igual",
                        "empty": "Vacío",
                        "contains": "Contiene",
                        "notEmpty": "No Vacío",
                        "without": "Sin"
                    }
                },
                "data": "Data",
                "deleteTitle": "Eliminar regla de filtrado",
                "leftTitle": "Criterios anulados",
                "logicAnd": "Y",
                "logicOr": "O",
                "rightTitle": "Criterios de sangría",
                "title": {
                    "0": "Constructor de búsqueda",
                    "_": "Constructor de búsqueda (%d)"
                },
                "value": "Valor"
            },
            "searchPanes": {
                "clearMessage": "Borrar todo",
                "collapse": {
                    "0": "Paneles de búsqueda",
                    "_": "Paneles de búsqueda (%d)"
                },
                "count": "{total}",
                "countFiltered": "{shown} ({total})",
                "emptyPanes": "Sin paneles de búsqueda",
                "loadMessage": "Cargando paneles de búsqueda",
                "title": "Filtros Activos - %d",
                "showMessage": "Mostrar Todo",
                "collapseMessage": "Colapsar Todo"
            },
            "select": {
                "cells": {
                    "1": "1 celda seleccionada",
                    "_": "%d celdas seleccionadas"
                },
                "columns": {
                    "1": "1 columna seleccionada",
                    "_": "%d columnas seleccionadas"
                },
                "rows": {
                    "1": "1 fila seleccionada",
                    "_": "%d filas seleccionadas"
                }
            },
            "thousands": ".",
            "datetime": {
                "previous": "Anterior",
                "next": "Proximo",
                "hours": "Horas",
                "minutes": "Minutos",
                "seconds": "Segundos",
                "unknown": "-",
                "amPm": [
                    "AM",
                    "PM"
                ],
                "months": {
                    "0": "Enero",
                    "1": "Febrero",
                    "10": "Noviembre",
                    "11": "Diciembre",
                    "2": "Marzo",
                    "3": "Abril",
                    "4": "Mayo",
                    "5": "Junio",
                    "6": "Julio",
                    "7": "Agosto",
                    "8": "Septiembre",
                    "9": "Octubre"
                },
                "weekdays": [
                    "Dom",
                    "Lun",
                    "Mar",
                    "Mie",
                    "Jue",
                    "Vie",
                    "Sab"
                ]
            },
            "editor": {
                "close": "Cerrar",
                "create": {
                    "button": "Nuevo",
                    "title": "Crear Nuevo Registro",
                    "submit": "Crear"
                },
                "edit": {
                    "button": "Editar",
                    "title": "Editar Registro",
                    "submit": "Actualizar"
                },
                "remove": {
                    "button": "Eliminar",
                    "title": "Eliminar Registro",
                    "submit": "Eliminar",
                    "confirm": {
                        "_": "¿Está seguro que desea eliminar %d filas?",
                        "1": "¿Está seguro que desea eliminar 1 fila?"
                    }
                },
                "error": {
                    "system": "Ha ocurrido un error en el sistema (<a target=\"\\\" rel=\"\\ nofollow\" href=\"\\\">Más información&lt;\\\/a&gt;).<\/a>"
                },
                "multi": {
                    "title": "Múltiples Valores",
                    "info": "Los elementos seleccionados contienen diferentes valores para este registro. Para editar y establecer todos los elementos de este registro con el mismo valor, hacer click o tap aquí, de lo contrario conservarán sus valores individuales.",
                    "restore": "Deshacer Cambios",
                    "noMulti": "Este registro puede ser editado individualmente, pero no como parte de un grupo."
                }
            },
            "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
            "stateRestore": {
                "creationModal": {
                    "button": "Crear",
                    "name": "Nombre:",
                    "order": "Clasificación",
                    "paging": "Paginación",
                    "search": "Busqueda",
                    "select": "Seleccionar",
                    "columns": {
                        "search": "Búsqueda de Columna",
                        "visible": "Visibilidad de Columna"
                    },
                    "title": "Crear Nuevo Estado",
                    "toggleLabel": "Incluir:"
                },
                "emptyError": "El nombre no puede estar vacio",
                "removeConfirm": "¿Seguro que quiere eliminar este %s?",
                "removeError": "Error al eliminar el registro",
                "removeJoiner": "y",
                "removeSubmit": "Eliminar",
                "renameButton": "Cambiar Nombre",
                "renameLabel": "Nuevo nombre para %s",
                "duplicateError": "Ya existe un Estado con este nombre.",
                "emptyStates": "No hay Estados guardados",
                "removeTitle": "Remover Estado",
                "renameTitle": "Cambiar Nombre Estado"
            }
        }
    </script>
@endsection
