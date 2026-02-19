<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Boucher de Venta</title>
    <style>
        body {
            font-family: Arial, sans-serif;

            width: 70mm;
            /* Tamaño de ancho del boucher */
        }

        .container {
            width: 100%;
            padding: 5mm;
            /* Espaciado interno */
            box-sizing: border-box;
        }

        .header {
            text-align: center;
        }

        .header h4 {
            /* Para que estén en línea */
            margin: 0;
            /* Elimina el margen que genera el espacio */
            padding: 0;
            /* Asegura que no haya espacio extra */
        }

        .logo {
            width: 60px;
            /* Ajusta el tamaño del logo */
            margin-bottom: 5mm;
        }

        .info {
            font-size: 13px;
            margin-bottom: 5mm;
            text-align: left;
        }

        .productos table {
            width: 100%;
            font-size: 13px;
            margin-bottom: 5mm;
            border-collapse: collapse;
            margin-left: -35px;
            /* Ajusta la posición de la tabla */
        }

        .productos table th,
        .productos table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        .total {
            text-align: right;
            font-weight: bold;
            font-size: 12px;
            margin-top: 5mm;
        }

        .footer {
            position: absolute;
            bottom: -5mm;
            width: 100%;
            font-size: 13px;
            text-align: center;
            margin-left: -35px;
            /* Ajusta la posición de la tabla */
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="<?php echo e($logo_url); ?>" alt="Logo" class="logo">
            <h4><?php echo e($nombre_negocio); ?></h4>
            <h4><?php echo e($regimen); ?></h4>
            <h4>RUC <?php echo e($ruc); ?></h4>
            <h4>AUT: <?php echo e($aut); ?></h4>
            <h4>Tel: <?php echo e($telefono_negocio); ?></h4>
        </div>

        <br>

        <div class="info">
            <p><strong>Factura:</strong> <?php echo e($factura); ?></p>
            <p><strong>Fecha:</strong> <?php echo e($fecha); ?></p>
            <p><strong>CAJERO:</strong> <?php echo e($usuario_generador); ?></p>
            <p><strong>Condicion :</strong> <?php echo e($direccion_negocio); ?></p>
            <p><strong>Cliente:</strong> <?php echo e($cliente); ?></p>
        </div>

        <div class="productos">
            <h4>Productos de la venta:</h3>
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $contador = 1;
                        ?>
                        <?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($contador++); ?></td>
                                <td><?php echo e($item->producto->nombre ?? 'Producto no disponible'); ?></td>
                                <td><?php echo e(number_format($item->precio, 2)); ?></td>
                                <td><?php echo e($item->cantidad); ?></td>
                                <td><?php echo e(number_format($item->subtotal, 2)); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
        </div>

        <div class="total">
            <p><strong>Total:</strong> $<?php echo e(number_format($total, 2)); ?></p>
            <p><strong>Paga:</strong> $<?php echo e(number_format($pago, 2)); ?></p>
            <p><strong>Cambio:</strong> $<?php echo e(number_format($vuelto, 2)); ?></p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>No hay Devoluciones, Gracias</strong></p>
            <p><strong>Regrese Pronto</strong></p>
        </div>
    </div>
</body>

</html>
<?php /**PATH C:\Users\xxman\OneDrive\Desktop\farmacia_laravel10\resources\views/admin/venta/boucher.blade.php ENDPATH**/ ?>