<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Venta Registrada</title>
</head>
<body>
    <h1>¡Se ha realizado una nueva venta!</h1>
    <p>El vendedor con ID <strong><?php echo e($venta->vendedor); ?></strong> ha registrado una venta.</p>
    <p><strong>Total:</strong> $<?php echo e(number_format($venta->total, 2)); ?></p>
    <p><strong>Cliente:</strong> <?php echo e($venta->id_cliente ?? 'No registrado'); ?></p>

    <h2>📦 Resumen de la venta</h2>
    <p><strong>Cantidad total de productos vendidos:</strong> <?php echo e($venta->detalles->sum('det_cantidad')); ?></p>

    <h3>🛒 Detalle de productos vendidos:</h3>
    <ul>
        <?php $__currentLoopData = $venta->detalles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detalle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li>
                <strong>Producto:</strong> <?php echo e($detalle->producto->nombre ?? 'Desconocido'); ?>

                | <strong>Cantidad:</strong> <?php echo e($detalle->det_cantidad); ?>

                | <strong>Vencimiento:</strong> <?php echo e($detalle->det_vencimiento ?? 'N/A'); ?>

                | <strong>Estado:</strong> <?php echo e($detalle->estado); ?>

            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>

    <p>Para más detalles, revisa el sistema.</p>
</body>
</html>
<?php /**PATH C:\Users\xxman\OneDrive\Desktop\farmacia_laravel10\resources\views/admin/emails/venta_realizada.blade.php ENDPATH**/ ?>