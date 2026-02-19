<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Restablecer Contraseña</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
            text-align: center;
        }

        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: auto;
        }

        .logo-container h1 {
            font-size: 36px;
            color: #3490dc;
            text-align: center;
            font-weight: bold;
        }


        .btn {
            display: inline-block;
            padding: 12px 20px;
            background: #0d24ef35;
            /* Color del botón */
            color: #0a0a0a;
            /* Color del texto */
            text-decoration: none;
            font-size: 16px;
            border-radius: 5px;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }


        .footer {
            font-size: 12px;
            color: #888;
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <div class="container">
        <!-- Cambia la ruta de tu logo aquí -->
        <div class="logo-container">
            <h1>Farmacia Farma-control</h1>
        </div>


        <h1>¡Hola!</h1>
        <p>Estás recibiendo este email porque se ha solicitado un cambio de contraseña para tu cuenta..</p>

        <p>
            <a href="{{ $actionUrl }}" class="btn">Restablecer contraseña</a>
        </p>

        <p>Este enlace para restablecer la contraseña caduca en 60 minutos..</p>

        <p>Si no has solicitado un cambio de contraseña, puedes ignorar o eliminar este e-mail.</p>

        <p>Saludos,<br><strong>Farmacia Farma-Control</strong></p>

        <hr>

        <p class="footer">

            Si tienes problemas haciendo click en el botón "Restablecer contraseña", copia y pega el siguiente enlace en
            tu navegador: <br>
            <a href="{{ $actionUrl }}">{{ $actionUrl }}</a>
        </p>

        <p class="footer">© {{ date('Y') }} Mi Empresa. Todos los derechos reservados.</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
