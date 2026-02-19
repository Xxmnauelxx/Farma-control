<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra Realizada</title>
</head>

<body>
    <h1>¡Nueva compra registrada!</h1>
    <p>Se ha realizado una nueva compra con el código <strong><?php echo e($compra->codigo); ?></strong>.</p>
    <p><strong>Fecha de compra:</strong> <?php echo e($compra->fecha_compra); ?></p>
    <p><strong>Fecha de Entrega:</strong> <?php echo e($compra->fecha_entrega); ?></p>
    <p><strong>Total:</strong> $<?php echo e(number_format($compra->total, 2)); ?></p>
    <p><strong>Proveedor:</strong> <?php echo e($compra->proveedor->nombre); ?></p>
    <p><strong>Estado de la Compra:</strong> <?php echo e($compra->estadoPago->nombre); ?></p>
    <p>Por favor, revisa el sistema para más detalles.</p>
</body>

</html>
<?php /**PATH C:\Users\xxman\OneDrive\Desktop\farmacia_laravel10\resources\views/admin/emails/compra_realizada.blade.php ENDPATH**/ ?>