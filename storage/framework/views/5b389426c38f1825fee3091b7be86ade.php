<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra N. <?php echo e($compra->codigo); ?></title>
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
            background: url(<?php echo e($bg1); ?>);
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
            <img src="<?php echo e($logoBase64); ?>" width="70" height="70" alt="Logo">
        </div>

        <h1>COMPRA N. <?php echo e($compra->codigo); ?></h1>

        <div id="company" class="clearfix">
            <div id="negocio"><?php echo e($compra->proveedor); ?></div>
            <div id="negocio"><?php echo e($compra->direccion); ?></div>
            <div id="negocio"><?php echo e($compra->telefono); ?></div>
            <div>
                <a href="mailto:<?php echo e($compra->correo); ?>"><?php echo e($compra->correo); ?></a>
            </div>
        </div>

        <div id="project">
            <div><span>Código de Compra: </span><?php echo e($compra->codigo); ?></div>
            <div><span>Fecha de Compra: </span><?php echo e($compra->fecha_compra); ?></div>
            <div><span>Fecha de Entrega: </span><?php echo e($compra->fecha_entrega); ?></div>
            <div><span>Estado: </span><?php echo e($compra->estado); ?></div>
        </div>
    </header>

    <?php if($compra->estado !== 'Cancelado'): ?>
        <div class="watermark">NO CANCELADO</div>
    <?php endif; ?>
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
                <?php $__currentLoopData = $lotes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lote): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="servic"><?php echo e($loop->iteration); ?></td>
                        <td class="servic"><?php echo e($lote->codigo); ?></td>
                        <td class="servic"><?php echo e($lote->cantidad); ?></td>
                        <td class="servic"><?php echo e($lote->vencimiento); ?></td>
                        <td class="servic">
                            CS/.<?php echo e(number_format($lote->precio_compra, 2)); ?></td>
                        <td class="servic"><?php echo e($lote->producto); ?> |
                            <?php echo e($lote->concentracion); ?></td>
                        <td class="servic"><?php echo e($lote->laboratorio); ?></td>
                        <td class="servic"><?php echo e($lote->presentacion); ?></td>
                        <td class="servic"><?php echo e($lote->tipo); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <?php
                    $subtotal = 0;

                    // Recorrer los lotes para calcular el subtotal
                    foreach ($lotes as $lote) {
                        $subtotal += $lote->precio_compra * $lote->cantidad; // Precio por cantidad
                    }

                    // Calcular IGV (18%)
                    $igv = $subtotal * 0.15;

                    // Calcular el total (Subtotal + IGV)
                    $total = $subtotal + $igv;
                ?>

                <tr>
                    <td colspan="8" class="grand total">SUBTOTAL</td>
                    <td class="grand total">CS/.<?php echo e(number_format($subtotal, 2)); ?></td>
                </tr>
                <tr>
                    <td colspan="8" class="grand total">IGV (15%)</td>
                    <td class="grand total">CS/.<?php echo e(number_format($igv, 2)); ?></td>
                </tr>
                <tr>
                    <td colspan="8" class="grand total">TOTAL</td>
                    <td class="grand total">CS/.<?php echo e(number_format($total, 2)); ?></td>
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
        <div>Created by Warpice (Elvis José Pavón Zeas) Ingeniero en Sistema.</div>
    </footer>
</body>

</html>
<?php /**PATH C:\Users\zease\Desktop\farmacia_laravel10\resources\views/admin/report/compra.blade.php ENDPATH**/ ?>