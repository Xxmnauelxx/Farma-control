<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Boucher de Venta</title>
    <style>
        body {
            font-family: Arial, sans-serif;

            width: 70mm; /* Tamaño de ancho del boucher */
        }
        .container {
            width: 100%;
            padding: 5mm; /* Espaciado interno */
            box-sizing: border-box;
        }
        .header {
            text-align: center;
            margin-bottom: 5mm;
        }
        .logo {
            width: 60px; /* Ajusta el tamaño del logo */
            margin-bottom: 5mm;
        }
        .info {
            font-size: 13px;
            margin-bottom: 5mm;
        }
        .productos table {
            width: 100%;
            font-size: 13px;
            margin-bottom: 5mm;
            border-collapse: collapse;
            margin-left: -35px; /* Ajusta la posición de la tabla */
        }
        .productos table th, .productos table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .total {
            text-align: right;
            font-weight: bold;
            font-size: 12px;
            margin-top: 10mm;
        }
        .footer {
            position: absolute;
            bottom: 5mm;
            width: 100%;
            font-size: 13px;
            text-align: center;
            margin-left: -35px; /* Ajusta la posición de la tabla */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ $logo_url }}" alt="Logo" class="logo">
            <h2>{{ $nombre_negocio }}</h2>
        </div>

        <div class="info">
            <p><strong>Fecha Venta:</strong> {{ $fecha }}</p>
            <p><strong>Cliente:</strong> {{ $cliente }}</p>
            <p><strong>Dirección:</strong> {{ $direccion_negocio }}</p>
            <p><strong>Teléfono:</strong> {{ $telefono_negocio }}</p>
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
                    @php
                        $contador = 1;
                    @endphp
                    @foreach($productos as $item)
                        <tr>
                            <td>{{ $contador++ }}</td>
                            <td>{{ $item->producto->nombre ?? 'Producto no disponible' }}</td>
                            <td>{{ number_format($item->precio, 2) }}</td>
                            <td>{{ $item->cantidad }}</td>
                            <td>{{ number_format($item->subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="total">
            <p><strong>Total:</strong> ${{ number_format($total, 2) }}</p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>Fecha de Impresión:</strong> {{ $fecha_impresion }}</p>
            <p><strong>Generado por:</strong> {{ $usuario_generador }}</p>
        </div>
    </div>
</body>
</html>
