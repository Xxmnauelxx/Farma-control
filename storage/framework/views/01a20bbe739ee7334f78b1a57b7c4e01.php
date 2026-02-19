<?php $__env->startSection('title', 'Inventario'); ?>
<?php $__env->startSection('css'); ?>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/v/dt/dt-2.1.3/datatables.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contenido'); ?>

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
                        <input id="buscarlote" type="text" class="form-control float-left"
                            placeholder="Ingrese Nombre Del Producto">
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

    <div class="modal fade" id="editarlote">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header badge badge-success">
                    <h5 class="modal-title" id="exampleModalLabel">Editar Lote</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo e(route('agregar_stock')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="form-group">
                            <label for="codigo_lote">Codigo Lote: </label>
                            <label id="codigo_lote">codigo</label>
                        </div>

                        <div class="form-group">
                            <label for="stock">Stock:</label>
                            <input id="stock" name="stock" type="number" class="form-control"
                                placeholder="Ingrese Stock" required>
                        </div>
                        <input type="hidden" id="id_lote_prod" name="id_lote_prod">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100">Agregar Stock</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
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
                var url = "<?php echo e(route('buscar_lotes')); ?>";
                $.ajax({
                    type: "GET", // Método HTTP: GET
                    url: url, // URL del endpoint para buscar productos
                    data: {
                        consulta: consulta
                    }, // Pasamos la consulta de búsqueda al servidor
                    success: function(data) {
                        console.log(data)
                        let template = '';
                        data.forEach(lote => {
                            template +=
                                `
                    <div loteId="${lote.id}" loteStock="${lote.stock}" loteCodigo="${lote.codigo}" class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">`;
                            if (lote.estado == 'success') {
                                template += `<div class="card bg-success d-flex flex-fill">`;
                            }

                            if (lote.estado == 'danger') {
                                template += `<div class="card bg-danger d-flex flex-fill">`;
                            }

                            if (lote.estado == 'warning') {
                                template += `<div class="card bg-warning d-flex flex-fill">`;
                            }

                            template += `<div class="card-header  border-bottom-0">
                         <h6>codigo ${lote.codigo}</h6>
                              <i class="fas fa-lg fa-cubes mr-1"></i> ${lote.stock}
                         </div>
                         <div class="card-body pt-0">
                              <div class="row">
                                <div class="col-8">
                                 <h2 class="lead"><b>${lote.nombre}</b></h2>
                                 <ul class="ml-4 mb-0 fa-ul">
                                 <li class="small"><span class="fa-li  mr-1"><i class="fas fa-lg fa-mortar-pestle"></i></span><b>Concentracion: </b> ${lote.concentracion}</li>
                                 <li class="small"><span class="fa-li"><i class="fas fa-lg fa-prescription-bottle-alt"></i></span><b> Adicional: </b>${lote.adicional}</li>
                                 <li class="small"><span class="fa-li"><i class="fas fa-lg fa-flask"></i></span><b>Laboratorio: </b>${lote.laboratorio}</li>
                                 <li class="small"><span class="fa-li"><i class="fas fa-lg fa-copyright"></i></span><b>Tipo: </b>${lote.tipo}</li>
                                 <li class="small"><span class="fa-li"><i class="fas fa-lg fa-pills"></i></span><b>Presentacion: </b>${lote.presentacion}</li>
                                 <li class="small"><span class="fa-li"><i class="fas fa-lg fa-calendar-times"></i></span><b>Vencimiento: </b>${lote.vencimiento}</li>
                                 <li class="small"><span class="fa-li"><i class="fas fa-lg fa-truck"></i></span><b>Proveedor: </b>${lote.proveedor}</li>
                                 <li class="small"><span class="fa-li"><i class="fas fa-lg fa-calendar-alt"></i></span><b>Año: </b>${lote.anio}</li>
                                 <li class="small"><span class="fa-li"><i class="fas fa-lg fa-calendar-alt"></i></span><b>Mes: </b>${lote.mes}</li>
                                 <li class="small"><span class="fa-li"><i class="fas fa-lg fa-calendar-day"></i></span><b>Dia: </b>${lote.dia}</li>
                                 <li class="small"><span class="fa-li"><i class="fas fa-lg fa-calendar-day"></i></span><b>Hora: </b>${lote.hora}</li>
                                 </ul>
                                </div>
                             <div class="col-4 text-center">
                                  <img src="${lote.avatar}" alt="user-avatar" class="img-circle img-fluid">
                                </div>
                            </div>
                            </div>
                             <div class="card-footer">
                                  <div class="row">
                                      <div class="col-6 text-center">
                                          <button class="editar btn btn-sm btn-success w-100" type="button" data-bs-toggle="modal" data-bs-target="#editarlote">
                                             <i class="fas fa-pencil-alt"></i> Editar
                                         </button>
                                        </div>
                                     <div class="col-6 text-center">
                                         <button class="borrar btn btn-sm btn-danger w-100">
                                               <i class="fas fa-trash-alt"></i> Borrar
                                         </button>
                                        </div>
                                 </div>
                                </div>
                            </div>
                            </div>
                            `;
                        });

                        $('#lote').html(template);
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

            // Escucha el evento de clic en cualquier botón con la clase 'editar'.
            $(document).on('click', '.editar', (e) => {
                // Obtiene el elemento HTML donde se hizo clic.
                let elemento = $(this)[0].activeElement.parentElement.parentElement.parentElement
                    .parentElement;

                // Extrae los atributos personalizados del elemento, que contienen la información del lote.
                let id = $(elemento).attr('loteId'); // ID del lote.
                let stock = $(elemento).attr('loteStock'); // Cantidad disponible en stock.
                let codigo = $(elemento).attr('loteCodigo'); // Código del lote.

                // Asigna los valores extraídos a los campos del formulario de edición.
                $('#id_lote_prod').val(id); // Campo oculto con el ID del lote.
                $('#stock').val(stock); // Campo donde se muestra el stock.
                $('#codigo_lote').html(codigo); // Muestra el código del lote en el HTML.
            });



            $(document).on('click', '.borrar', (e) => {
                const elemento = $(e.currentTarget).closest('[loteId]');
                const id = $(elemento).attr('loteId');

                let url = "<?php echo e(route('borrar_lote', ['id' => ':id'])); ?>";
                url = url.replace(':id', id);

                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger mr-1'
                    },
                    buttonsStyling: false
                });

                swalWithBootstrapButtons.fire({
                    title: '¿Desea eliminar el Lote con ID: ' + id + '?',
                    text: "No podrás revertir esto!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: 'Sí, Borrar Esto!',
                    cancelButtonText: 'No, Cancelar!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: 'POST', // Cambiado a DELETE en lugar de POST
                            data: {
                                _token: "<?php echo e(csrf_token()); ?>" // Se agrega el token CSRF
                            },
                            dataType: 'json',
                            success: (response) => {
                                console.log(response);
                                if (response === 'borrado') {
                                    swalWithBootstrapButtons.fire(
                                        '¡Borrado!',
                                        'El Lote ' + id +
                                        ' fue marcado como inactivo.',
                                        'success'
                                    );
                                    buscar_lotes();
                                } else {
                                    swalWithBootstrapButtons.fire(
                                        'No Se Pudo Borrar!',
                                        'El Lote ' + id +
                                        ' no fue borrado porque está siendo usado.',
                                        'error'
                                    );
                                }
                            },
                            error: (xhr, status, error) => {
                                console.error('Error en la petición:', error);
                                swalWithBootstrapButtons.fire(
                                    'Error!',
                                    'Ocurrió un error al intentar eliminar el lote.',
                                    'error'
                                );
                            }
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        swalWithBootstrapButtons.fire(
                            'No Se Pudo Borrar',
                            'El Lote ' + id + ' no fue borrado.',
                            'error'
                        );
                    }
                });
            });








        });
    </script>



<?php $__env->stopSection(); ?>

<?php echo $__env->make('Layouts.pantilla', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\xxman\OneDrive\Desktop\farmacia_laravel10\resources\views/admin/inventario/index.blade.php ENDPATH**/ ?>