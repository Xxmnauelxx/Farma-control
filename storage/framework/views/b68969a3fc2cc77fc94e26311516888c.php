<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> REPORTE PRODUCTOS</title>
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
            font-weight: bold;
            text-transform: uppercase;
            z-index: 1000;
            /* Asegúrate que esté por encima de otros elementos */
            white-space: nowrap;
            pointer-events: none;
            /* No interfiere con clics en la tabla */
        }

        .watermark.cancelado {
            color: rgba(255, 0, 0, 0.2);
            /* Rojo con transparencia */
        }

        .watermark.facturado {
            color: rgba(0, 255, 0, 0.2);
            /* Verde con transparencia */
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
            padding: 5px 5px;
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
            bottom: -250px;
            border-top: 1px solid #C1CED9;
            text-align: center;
        }


        #notices {
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 8px;
            margin-top: 20px;
            text-align: center;
            border: 1px solid #ddd;
        }

        .notice-title {
            font-size: 10px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        .notice-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            font-size: 10px;
            color: #555;
        }

        .notice-item:last-child {
            margin-bottom: 0;
        }

        .notice-icon {
            font-size: 10px;
            margin-right: 10px;
            color: #FF5722;
            /* Puedes ajustar el color del icono según tu preferencia */
        }

        .notice-text {
            font-size: 10px;
            line-height: 1.4;
        }

        .notice-item:hover {
            background-color: #f1f1f1;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .notice-item:hover .notice-icon {
            color: #E91E63;
            /* Cambia el color del icono cuando se pasa el ratón por encima */
        }
    </style>
</head>


<body>
    <header class="clearfix">
        <div id="logo">
            <img src="<?php echo e($logoBase64); ?>" width="70" height="70" alt="Logo">
        </div>

        <h1>REPORTE DE PRODUCTOS</h1>
        <div id="">
            <span style="color: rgb(2, 14, 244)">Fecha y Hora Impresion: </span> <?php echo e(now()->format('d/m/Y H:i:s')); ?>

        </div>
    </header>

    <main>
        <table>
            <thead>
                <tr>
                    <th>N*</th>
                    <th>Producto</th>
                    <th>Concentracion</th>
                    <th>Adicional</th>
                    <th>Laboratorio</th>
                    <th>Presentacion</th>
                    <th>Tipo</th>
                    <th>Stock</th>
                    <th>Precio</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="servic"><?php echo e($index + 1); ?></td>
                        <td class="servic"><?php echo e($producto->nombre); ?></td>
                        <td class="servic"><?php echo e($producto->concentracion); ?></td>
                        <td class="servic"><?php echo e($producto->adicional); ?></td>
                        <td class="servic"><?php echo e($producto->laboratorio); ?></td>
                        <td class="servic"><?php echo e($producto->presentacion); ?></td>
                        <td class="servic"><?php echo e($producto->tipo); ?></td>
                        <td class="servic"><?php echo e($producto->stock); ?></td>
                        <td class="servic"><?php echo e(number_format($producto->precio, 2)); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
<?php /**PATH C:\Users\zease\Desktop\farmacia_laravel10\resources\views/admin/report/productos.blade.php ENDPATH**/ ?>