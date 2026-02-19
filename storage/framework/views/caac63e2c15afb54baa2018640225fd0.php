<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Recuperar Password</title>

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="shortcut icon" href="<?php echo e(asset('img/logo2.png')); ?>" type="image/x-icon" />
    <link rel="stylesheet" href="<?php echo e(asset('plugins/fontawesome-free/css/all.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('dist/css/adminlte.min.css')); ?>">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <span class="h4"><b>Farmacia</b>Farma-Control</span>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Recuperar Contraseña</p>

                <?php if(session('status')): ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo e(session('status')); ?>

                    </div>
                <?php endif; ?>
                <form method="POST" action="<?php echo e(route('enviar_email')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" name="email" placeholder="Correo Electrónico" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Enviar Enlace de Recuperación</button>
                        </div>
                    </div>
                </form>

                <p class="mt-3 mb-1">
                    <a href="<?php echo e(route('login')); ?>">Volver atras</a>
                </p>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="<?php echo e(asset('plugins/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('dist/js/adminlte.js')); ?>"></script>
</body>

</html>
<?php /**PATH C:\Users\xxman\OneDrive\Desktop\farmacia_laravel10\resources\views/admin/usuario/recuperar_pass.blade.php ENDPATH**/ ?>