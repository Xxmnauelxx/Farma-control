<?php $__env->startSection('title', 'Cliente'); ?>
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
                    <h4> <i class="fas fa-user-shield"> Clientes</i>
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalcreacli">
                            Nuevo cliente
                        </button>
                    </h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
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

                <div class="card-body">
                    <table id="cliesTable" class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th style="text-align: center">Teléfono</th>
                                <th>DNI</th>
                                <th style="text-align: center">Fecha Nacimiento</th>
                                <th>Foto</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $contador = 1;
                            ?>

                            <?php $__currentLoopData = $cliente; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cli): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($contador++); ?></td>
                                    <td><?php echo e($cli->nombre); ?> <?php echo e($cli->apellidos); ?></td>
                                    <td style="text-align: center"><?php echo e($cli->telefono); ?></td>
                                    <td style="text-align: center"><?php echo e($cli->dni); ?></td>
                                    <td style="text-align: center"><?php echo e($cli->edad); ?></td>
                                    <td>
                                        <?php
                                            $rutaImagen = public_path($cli->avatar);
                                        ?>

                                        <?php if(file_exists($rutaImagen) && !is_dir($rutaImagen)): ?>
                                            <img src="<?php echo e(asset($cli->avatar)); ?>" class="img-fluid img-circle"
                                                style="width: 40px; cursor: none;">
                                        <?php else: ?>
                                            <img src="<?php echo e(asset('img/cl.png')); ?>" class="img-fluid img-circle"
                                                style="width: 40px; cursor: none;">
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <?php if($cli->estado == 'Activo'): ?>
                                            <span class="badge bg-success">Activo</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Inactivo</span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <button type="button" class="avatar btn btn-sm btn-info"
                                            data-id="<?php echo e($cli->id); ?>" data-nombre="<?php echo e($cli->nombre); ?>"
                                            data-avatar="<?php echo e(asset($cli->avatar ?? 'img/cli.png')); ?>">
                                            <i class="fas fa-image"></i>
                                        </button>

                                        <button class="editar-cli btn btn-sm btn-success" type="button"
                                            data-id="<?php echo e($cli->id); ?>" data-toggle="modal"
                                            data-target="#modaleditarcli">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>

                                        <button class="ver btn btn-sm btn-primary" data-id="<?php echo e($cli->id); ?>"
                                            data-nombre="<?php echo e($cli->nombre); ?>" data-toggle="modal"
                                            data-target="#modalvercli">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        <button class="borrar btn btn-sm btn-danger" data-id="<?php echo e($cli->id); ?>"
                                            data-nombre="<?php echo e($cli->nombre); ?>">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal crear cli -->
    <div class="modal fade" id="modalcreacli">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Crear Clientes</h3>
                        <button data-bs-dismiss="modal" aria-label="close" class="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo e(route('crear_cliente')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <div class="row">
                                <!-- Columna 1 -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nombre">Nombres:</label>
                                        <input id="nombre" name="nombre" type="text" class="form-control"
                                            placeholder="Ingrese Nombre" required>
                                    </div>
                                </div>
                                <!-- Columna 2 -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="apellidos">Apellidos:</label>
                                        <input id="apellidos" name="apellidos" type="text" class="form-control"
                                            placeholder="Ingrese Apellidos" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Columna 1 -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="dni">DNI:</label>
                                        <input id="dni" name="dni" type="text" class="form-control"
                                            placeholder="Ingrese DNI">
                                    </div>
                                </div>
                                <!-- Columna 2 -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="f_nac">Nacimiento:</label>
                                        <input id="f_nac" name="f_nac" type="date" class="form-control"
                                            placeholder="Ingrese Fecha De Nacimiento" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Columna 1 -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="telefono">Telefono:</label>
                                        <input id="telefono" name="telefono" type="number" class="form-control"
                                            placeholder="Ingrese Telefono">
                                    </div>
                                </div>
                                <!-- Columna 2 -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="correo">Correo</label>
                                        <input id="correo" name="correo" type="email" class="form-control"
                                            placeholder="Ingrese Correo">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Columna 1 -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sexo">Sexo:</label>
                                        <select name="id_sexo" id="id_sexo" class="form-control select2"
                                            style="width: 100%">
                                            <option value="">Seleccionar</option>
                                            <?php $__currentLoopData = $sexo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($item->id); ?>"><?php echo e($item->nombre); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <!-- Columna 2 -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="adicional">Direccion:</label>
                                        <textarea name="direccion" id="direccion" class="form-control" placeholder="Ingrese su direccion">

                                        </textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit"
                                    class="btn bg-gradient-primary float-right m-1 w-100">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de cambiar logo -->
    <div class="animate__animated animate__bounceInDown modal fade" id="cambiologo">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h5 class="modal-title">Cambiar Foto De Cliente</h5>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <img id='logoactual' src="<?php echo e(asset('img/cli.png')); ?>"
                            class="profile-user-img img-fluid img-circle">
                    </div>
                    <div class="text-center">
                        <b id="nombre_logo"></b>
                    </div>

                    <form action="<?php echo e(route('cambiar_foto_cliente')); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="input-group mb-3 ml-5 mt-2">
                            <!-- SE AGREGA ID AL INPUT -->
                            <input type="file" id="photo" name="photo" class="input-group">
                            <input type="hidden" name="funcion" id="funcion">
                            <input type="hidden" name="id-logo-cli" id="id-logo-cli">
                        </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn bg-gradient-primary w-100">Guardar</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal editar cli -->
    <div class="modal fade" id="modaleditarcli">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Editar Clientes</h3>
                        <button data-bs-dismiss="modal" aria-label="close" class="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo e(route('actualizar_cliente')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>
                            <div class="row">
                                <!-- Columna 1 -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nombre">Nombres:</label>
                                        <input id="nombre_edit" name="nombre_edit" type="text" class="form-control"
                                            placeholder="Ingrese Nombre" required>
                                    </div>
                                </div>
                                <!-- Columna 2 -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="apellidos">Apellidos:</label>
                                        <input id="apellidos_edit" name="apellidos_edit" type="text"
                                            class="form-control" placeholder="Ingrese Apellidos" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Columna 1 -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="dni">DNI:</label>
                                        <input id="dni_edit" name="dni_edit" type="text" class="form-control"
                                            placeholder="Ingrese DNI">
                                    </div>
                                </div>
                                <!-- Columna 2 -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="f_nac">Nacimiento:</label>
                                        <input id="f_nac_edit" name="f_nac_edit" type="date" class="form-control"
                                            placeholder="Ingrese Fecha De Nacimiento" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Columna 1 -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="telefono">Telefono:</label>
                                        <input id="telefono_edit" name="telefono_edit" type="number"
                                            class="form-control" placeholder="Ingrese Telefono">
                                    </div>
                                </div>
                                <!-- Columna 2 -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="correo">Correo</label>
                                        <input id="correo_edit" name="correo_edit" type="email" class="form-control"
                                            placeholder="Ingrese Correo">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Columna 1 -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sexo">Sexo:</label>
                                        <select name="id_sexo_edit" id="id_sexo_edit" class="form-control select2"
                                            style="width: 100%">
                                            <option value="">Seleccionar</option>
                                            <?php $__currentLoopData = $sexo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($item->id); ?>"><?php echo e($item->nombre); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <!-- Columna 2 -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="adicional">Direccion:</label>
                                        <textarea name="direccion_edit" id="direccion_edit" class="form-control" placeholder="Ingrese su direccion">

                                        </textarea>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="id_edit_cli" id="id_edit_cli">

                            <div class="card-footer">
                                <button type="submit"
                                    class="btn bg-gradient-primary float-right m-1 w-100">Actualizar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal ver cli -->
    <div class="modal fade" id="modalvercli">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Detalles del Cliente</h3>
                        <button data-dismiss="modal" aria-label="close" class="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Columna 1 -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nombre">Nombres:</label>
                                    <input id="nombre_view" type="text" class="form-control" readonly>
                                </div>
                            </div>
                            <!-- Columna 2 -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="apellidos">Apellidos:</label>
                                    <input id="apellidos_view" type="text" class="form-control" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Columna 1 -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="dni">DNI:</label>
                                    <input id="dni_view" type="text" class="form-control" readonly>
                                </div>
                            </div>
                            <!-- Columna 2 -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="f_nac">Nacimiento:</label>
                                    <input id="f_nac_view" type="date" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="edad">Edad (Años):</label>
                                <input id="edad_view" type="text" class="form-control" readonly>
                            </div>
                        </div>


                        <div class="row" <!-- Columna 1 -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="telefono">Teléfono:</label>
                                    <input id="telefono_view" type="number" class="form-control" readonly>
                                </div>
                            </div>
                            <!-- Columna 2 -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="correo">Correo</label>
                                    <input id="correo_view" type="email" class="form-control" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Columna 1 -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sexo">Sexo:</label>
                                    <select id="id_sexo_view" class="form-control select2" disabled>
                                        <option value="">Seleccionar</option>
                                        <?php $__currentLoopData = $sexo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($item->id); ?>"><?php echo e($item->nombre); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <!-- Columna 2 -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="direccion">Dirección:</label>
                                    <textarea id="direccion_view" class="form-control" readonly></textarea>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" id="id_view_cli">
                    </div>
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

    <?php if($errors->any()): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '<?php echo e($errors->first()); ?>',
            });
        </script>
    <?php endif; ?>

    <script>
        $(document).ready(function() {
            $('#id_sexo').select2();
            $('#id_sexo_edit').select2()

            $('#cliesTable').DataTable();

            // Detectar cambio en input file y mostrar la imagen seleccionada
            $('#photo').change(function(event) {
                var file = event.target.files[0]; // Obtener archivo
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#logoactual').attr('src', e.target.result); // Mostrar en modal
                    };
                    reader.readAsDataURL(file);
                } else {
                    console.warn("No se seleccionó ningún archivo.");
                }
            });


            $('#cliesTable').on('click', '.avatar', function(e) {
                var id = $(this).data('id');
                var nombre = $(this).data('nombre');
                var avatar = $(this).data('avatar');

                // Si el cl ya tiene foto, mostrarla; si no, usar la default
                $('#logoactual').attr('src', avatar || "<?php echo e(asset('img/cli.png')); ?>");
                $('#nombre_logo').html(nombre);
                $('#id-logo-cli').val(id);

                $('#cambiologo').modal('show');
            });


            $('#cliesTable').on('click', '.editar-cli', function() {
                var id = $(this).data('id');
                $('#id_edit_cli').val(id);

                var url = "<?php echo e(route('extraer_datos_cliente', ['id' => ':id'])); ?>";
                url = url.replace(':id', id);

                $.ajax({
                    type: "GET",
                    url: url,
                    dataType: "json", // Aseguramos que la respuesta sea JSON
                    success: function(response) {
                        console.log(response)
                        if (response.success) {
                            var cl = response.data;
                            // Llenar los campos del modal con los datos obtenidos
                            $('#nombre_edit').val(cl.nombre);
                            $('#apellidos_edit').val(cl.apellidos);
                            $('#correo_edit').val(cl.correo);
                            $('#telefono_edit').val(cl.telefono);
                            $('#direccion_edit').val(cl.direccion);
                            $('#dni_edit').val(cl.dni);
                            $('#f_nac_edit').val(cl.edad);
                            $('#id_sexo_edit').val(cl.sexo_id).change();
                            // Mostrar el modal
                            $('#modalEditarcl').modal('hide');
                        } else {
                            alert("No se encontraron datos del cl.");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error en la petición AJAX:", error);
                    }
                });
            });


            $('#cliesTable').on('click', '.borrar', function() {
                var id = $(this).data('id');
                var nombre = $(this).data('nombre');

                var url = "<?php echo e(route('eliminar_cliente', ['id' => ':id'])); ?>";
                url = url.replace(':id', id);

                Swal.fire({
                    title: "¿Estás seguro?",
                    text: "Se eliminará el cliente: " + nombre,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Sí, eliminar",
                    cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: "POST",
                            data: {
                                _token: "<?php echo e(csrf_token()); ?>",
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire("¡Inactivado!", response.message,
                                            "success")
                                        .then(() => {
                                            location
                                        .reload(); // Recargar la página o actualizar la tabla
                                        });
                                } else {
                                    Swal.fire("Error", response.message, "error");
                                }
                            },
                            error: function(xhr, status, error) {
                                Swal.fire("Error", "No se pudo inactivar el cliente.",
                                    "error");
                            }
                        });
                    }
                });

            })

            $('#cliesTable').on('click', '.ver', function() {
                var id = $(this).data('id');
                $('#id_edit_cli').val(id);

                var url = "<?php echo e(route('extraer_datos_cliente', ['id' => ':id'])); ?>";
                url = url.replace(':id', id);

                $.ajax({
                    type: "GET",
                    url: url,
                    dataType: "json", // Aseguramos que la respuesta sea JSON
                    success: function(response) {
                        console.log(response)
                        if (response.success) {
                            var cl = response.data;
                            // Llenar los campos del modal con los datos obtenidos
                            $('#nombre_view').val(cl.nombre);
                            $('#apellidos_view').val(cl.apellidos);
                            $('#correo_view').val(cl.correo);
                            $('#telefono_view').val(cl.telefono);
                            $('#direccion_view').val(cl.direccion);
                            $('#dni_view').val(cl.dni);
                            $('#f_nac_view').val(cl.edad);
                            $('#edad_view').val(response.edad_fecha);
                            $('#id_sexo_view').val(cl.sexo_id).change();
                            // Mostrar el modal
                            $('#modalEditarcl').modal('hide');
                        } else {
                            alert("No se encontraron datos del cl.");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error en la petición AJAX:", error);
                    }
                });
            });
        });
    </script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('Layouts.pantilla', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\xxman\OneDrive\Desktop\farmacia_laravel10\resources\views/admin/cliente/index.blade.php ENDPATH**/ ?>