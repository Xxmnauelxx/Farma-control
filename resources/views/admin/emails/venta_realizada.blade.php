<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Venta Registrada</title>
</head>
<body>
    <h1>¡Se ha realizado una nueva venta!</h1>
    <p>El vendedor con ID <strong>{{ $venta->vendedor }}</strong> ha registrado una venta.</p>
    <p><strong>Total:</strong> ${{ number_format($venta->total, 2) }}</p>
    <p><strong>Cliente:</strong> {{ $venta->id_cliente ?? 'No registrado' }}</p>

    <h2>📦 Resumen de la venta</h2>
    <p><strong>Cantidad total de productos vendidos:</strong> {{ $venta->detalles->sum('det_cantidad') }}</p>

    <h3>🛒 Detalle de productos vendidos:</h3>
    <ul>
        @foreach ($venta->detalles as $detalle)
            <li>
                <strong>Producto:</strong> {{ $detalle->producto->nombre ?? 'Desconocido' }}
                | <strong>Cantidad:</strong> {{ $detalle->det_cantidad }}
                | <strong>Vencimiento:</strong> {{ $detalle->det_vencimiento ?? 'N/A' }}
                | <strong>Estado:</strong> {{ $detalle->estado }}
            </li>
        @endforeach
    </ul>

    <p>Para más detalles, revisa el sistema.</p>
</body>
</html>
