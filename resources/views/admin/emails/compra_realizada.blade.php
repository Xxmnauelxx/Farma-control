<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra Realizada</title>
</head>

<body>
    <h1>¡Nueva compra registrada!</h1>
    <p>Se ha realizado una nueva compra con el código <strong>{{ $compra->codigo }}</strong>.</p>
    <p><strong>Fecha de compra:</strong> {{ $compra->fecha_compra }}</p>
    <p><strong>Fecha de Entrega:</strong> {{ $compra->fecha_entrega }}</p>
    <p><strong>Total:</strong> ${{ number_format($compra->total, 2) }}</p>
    <p><strong>Proveedor:</strong> {{ $compra->proveedor->nombre }}</p>
    <p><strong>Estado de la Compra:</strong> {{ $compra->estadoPago->nombre }}</p>
    <p>Por favor, revisa el sistema para más detalles.</p>
</body>

</html>
