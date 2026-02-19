<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra N. {{ $compra->codigo }}</title>
    <style>
        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        a {
            color: #5D6975;
            text-decoration: underline;
        }


        /*encabezado morado*/
        table thead tr {
            height: 20px;
            background: rgb(70, 83, 83);
        }

        body {
            position: relative;
            width: 19cm;
            height: 29.7cm;
            margin: 0 auto;
            color: #050605;
            background: #FFFFFF;
            font-family: Arial, sans-serif;
            font-size: 12px;
            font-family: Arial;
        }

        .watermark {
    position: absolute;
    top: 45%;
    left: 50%;
    transform: translate(-50%, -90%) rotate(-50deg);
    font-size: 80px;
    color: rgba(255, 0, 0, 0.2); /* Rojo con transparencia */
    font-weight: bold;
    text-transform: uppercase;
    z-index: 1000; /* Mayor que la tabla */
    white-space: nowrap;
    pointer-events: none; /* No interfiere con clics en la tabla */
}




        header {
            padding: 10px 0;
            margin-bottom: 30px;
        }

        #logo {
            text-align: center;
            margin-bottom: 10px;
            margin-top: 20px;
            margin-left: 30px;
            margin-right: 40px;
        }

        #logo img {
            width: 80px;
            height: 80px;
        }

        h1 {
            border-top: 1px solid rgb(115, 97, 119);
            border-bottom: 1px solid rgb(34, 33, 34);
            color: rgb(2, 175, 65);
            font-size: 2.4em;
            line-height: 1.4em;
            font-weight: normal;
            text-align: center;
            margin: 0 0 20px 0;
            background: url({{ $bg1 }});
        }

        #project {
            float: left;
            color: rgb(0, 0, 0);
        }

        #project span {
            color: rgb(4, 74, 9);
            text-align: left;
            width: 130px;
            margin-right: 10px;
            display: inline-block;
            font-size: 13px;
        }

        #company {
            float: right;
            text-align: right;
        }

        #project div {
            font-size: 14px;
        }

        #company div {
            white-space: nowrap;
        }

        #negocio {
            font-size: 15px;
            color: rgb(4, 74, 9);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 20px;
        }

        table tr:nth-child(2n-1) td {
            background: rgb(222, 227, 228);
        }

        table th,
        table td {
            text-align: center;
        }

        table th {
            padding: 5px 10px;
            color: rgb(243, 234, 234);
            border-bottom: 1px solid #cee1f1;
            white-space: nowrap;
            font-weight: normal;
            font-size: 15px;
        }

        table .service {
            text-align: left;
        }

        table td.service {
            vertical-align: top;
        }

        table .servic {
            text-align: center;
        }

        table td.servic {
            vertical-align: top;
        }

        table td {
            font-size: 11px;
            text-align: right;
        }

        table td.total {
            font-size: 12px;
            color: rgb(3, 80, 0);
        }

        table td.grand {
            border-top: 1px solid rgb(3, 80, 0);
        }

        #notices .notice {
            color: rgb(115, 117, 93);
            font-size: 1.2em;
        }

        footer {
            color: #5D6975;
            width: 100%;
            height: 10px;
            position: relative;
            bottom: -400px;
            border-top: 1px solid #C1CED9;
            text-align: center;
        }
    </style>
</head>

<body>
    <header class="clearfix">
        <div id="logo">
            <img src="{{ $logoBase64 }}" width="70" height="70" alt="Logo">
        </div>

        <h1>COMPRA N. {{ $compra->codigo }}</h1>

        <div id="company" class="clearfix">
            <div id="negocio">{{ $compra->proveedor }}</div>
            <div id="negocio">{{ $compra->direccion }}</div>
            <div id="negocio">{{ $compra->telefono }}</div>
            <div>
                <a href="mailto:{{ $compra->correo }}">{{ $compra->correo }}</a>
            </div>
        </div>

        <div id="project">
            <div><span>Código de Compra: </span>{{ $compra->codigo }}</div>
            <div><span>Fecha de Compra: </span>{{ $compra->fecha_compra }}</div>
            <div><span>Fecha de Entrega: </span>{{ $compra->fecha_entrega }}</div>
            <div><span>Estado: </span>{{ $compra->estado }}</div>
        </div>
    </header>

    @if ($compra->estado !== 'Cancelado')
        <div class="watermark">NO CANCELADO</div>
    @endif
    <main>
        <table>
            <thead>
                <tr>
                    <th class="service">#</th>
                    <th class="service">Códig</th>
                    <th class="service">Cant</th>
                    <th class="service">Venc</th>
                    <th class="service">P.Compra</th>
                    <th class="service">Producto</th>
                    <th class="service">Laboratorio</th>
                    <th class="service">Presentación</th>
                    <th class="service">Tipo</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lotes as $lote)
                    <tr>
                        <td class="servic">{{ $loop->iteration }}</td>
                        <td class="servic">{{ $lote->codigo }}</td>
                        <td class="servic">{{ $lote->cantidad }}</td>
                        <td class="servic">{{ $lote->vencimiento }}</td>
                        <td class="servic">
                            CS/.{{ number_format($lote->precio_compra, 2) }}</td>
                        <td class="servic">{{ $lote->producto }} |
                            {{ $lote->concentracion }}</td>
                        <td class="servic">{{ $lote->laboratorio }}</td>
                        <td class="servic">{{ $lote->presentacion }}</td>
                        <td class="servic">{{ $lote->tipo }}</td>
                    </tr>
                @endforeach

                @php
                    $subtotal = 0;

                    // Recorrer los lotes para calcular el subtotal
                    foreach ($lotes as $lote) {
                        $subtotal += $lote->precio_compra * $lote->cantidad; // Precio por cantidad
                    }

                    // Calcular IGV (18%)
                    $igv = $subtotal * 0.15;

                    // Calcular el total (Subtotal + IGV)
                    $total = $subtotal + $igv;
                @endphp

                <tr>
                    <td colspan="8" class="grand total">SUBTOTAL</td>
                    <td class="grand total">CS/.{{ number_format($subtotal, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="8" class="grand total">IGV (15%)</td>
                    <td class="grand total">CS/.{{ number_format($igv, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="8" class="grand total">TOTAL</td>
                    <td class="grand total">CS/.{{ number_format($total, 2) }}</td>
                </tr>

            </tbody>
        </table>

        <div id="notice">
            <div>NOTICE:</div>
            <div class="notice">
                * Este es un documento generado automáticamente para fines informativos.
            </div>
        </div>
    </main>

    <footer>
        <div>Created by Warpice (Manuel Tananta Lino) Ingeniero en Sistema.</div>
    </footer>
</body>

</html>
