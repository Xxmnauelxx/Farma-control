<?php $__env->startSection('title', 'Ventas'); ?>
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
                    <h4><i class="fas fa-user-shield"> </i>

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
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                        </div>
                        <div class="card-body">
                            <header class="text-center mb-3">
                                <!-- Datos -->
                                <div class="datos_cp">
                                    <!-- Cliente Registrado -->
                                    <div class="form-group row">
                                        <label for="cliente_registrado" class="col-form-label col-md-2">Cliente:</label>
                                        <div class="col-md-10">
                                            <select id="cliente_registrado" class="form-control select2" style="width:100%">
                                                <option value="">Seleccione un cliente</option>
                                                <?php $__currentLoopData = $cliente; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cliente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($cliente->id); ?>"><?php echo e($cliente->nombre); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Cliente No Registrado -->
                                    <div class="form-group row">
                                        <label for="cliente_no_registrado" class="col-form-label col-md-2">Cliente No
                                            Registrado:</label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" id="cliente_no_registrado"
                                                placeholder="Nombre del Cliente">
                                        </div>
                                    </div>

                                    <!-- Vendedor -->
                                    <div class="form-group row">
                                        <label for="vendedor" class="col-form-label col-md-2">Vendedor: </label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" id="vendedor"
                                                value="<?php echo e($nombre); ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                            </header>

                            <button class="btn btn-success mb-2" id="act">Actualizar</button>

                            <div id="cp" class="card-body table-responsive p-0">
                                <table class="compra display table table-hover text-nowrap " id="tablacompra">
                                    <thead class="table-success">
                                        <tr>
                                            <th scope="col">Nombre</th>
                                            <th scope="col">Stock</th>
                                            <th scope="col">Precio</th>
                                            <th scope="col">Concent</th>
                                            <th scope="col">Adicional</th>
                                            <th scope="col">Lab</th>
                                            <th scope="col">Pres</th>
                                            <th scope="col">Cantidad</th>
                                            <th scope="col">Sub Total</th>
                                            <th scope="col">Eliminar</th>
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
                                                        <span class="info-box-number" id="subtotal">0</span>
                                                    </div>
                                                </div>
                                                <div class="info-box mb-3 bg-warning">
                                                    <span class="info-box-icon"><i class="fas fa-tag"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-text text-left ">IGV</span>
                                                        <span class="info-box-number"id="con_igv">0</span>
                                                    </div>
                                                </div>
                                                <div class="info-box mb-3 bg-info">
                                                    <span class="info-box-icon"><i class="fas fa-tag"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-text text-left ">SIN DESCUENTO</span>
                                                        <span class="info-box-number" id="total_sin_descuento">0</span>
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
                                                    <span class="info-box-icon"><i
                                                            class="fas fa-comment-dollar"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-text text-left ">DESCUENTO</span>
                                                        <input id="descuento"type="number" min="1"
                                                            placeholder="Ingrese descuento" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="info-box mb-3 bg-info">
                                                    <span class="info-box-icon"><i
                                                            class="ion ion-ios-cart-outline"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-text text-left ">TOTAL</span>
                                                        <span class="info-box-number" id="total">0</span>
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
                                                    <span class="info-box-icon"><i
                                                            class="fas fa-money-bill-alt"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-text text-left ">INGRESO</span>
                                                        <input type="number" id="pago" min="1"
                                                            placeholder="Ingresa Dinero" class="form-control">

                                                    </div>
                                                </div>
                                                <div class="info-box mb-3 bg-info">
                                                    <span class="info-box-icon"><i
                                                            class="fas fa-money-bill-wave"></i></span>
                                                    <div class="info-box-content">
                                                        <span class="info-box-text text-left ">VUELTO</span>
                                                        <span class="info-box-number" id="vuelto">0</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>


                            <div class="row justify-content-between">
                                <div class="col-md-4 mb-2">
                                    <a href="<?php echo e(route('home')); ?>" class="btn btn-primary btn-block">Seguir
                                        comprando</a>
                                </div>
                                <div class="col-xs-12 col-md-4">
                                    <a href="#" class="btn btn-success btn-block" id="procesar-compra">Realizar
                                        compra</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/v/dt/dt-2.1.3/datatables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script>
        var urlBuscarProducto = "<?php echo e(route('buscar_productos')); ?>";
        var urlLoteRiesgo = "<?php echo e(route('lotes_riesgo')); ?>";
        var rutaBuscarProdCompra = "<?php echo e(route('proceso_compra')); ?>";
        var rutaProdCompra = "<?php echo e(route('buscar_prod', ['id' => ':id'])); ?>";
        var rutaProdComprabuscar = "<?php echo e(route('buscar_prod_compra')); ?>";
        var home = "<?php echo e(route('home')); ?>";
        var CrearVenta = "<?php echo e(route('enviar_venta')); ?>";
        var generarBoucherURL = "<?php echo e(route('generar_boucher', ['id' => '__ID__'])); ?>";
    </script>

    <script src="<?php echo e(asset('js/carrito.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('Layouts.pantilla', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\zease\Desktop\farmacia_laravel10\resources\views/admin/venta/index.blade.php ENDPATH**/ ?>