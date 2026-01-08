<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" href="<?php echo e(asset('img/icon.png')); ?>">
        <meta name="author" content="Deivis Henriquez deivis(at)vozip.net and Braian Jaimes braian.jaimes(at)directagroup.net"/>
        <meta name="copyright" content="Powered by Deivis Henriquez and Braian Jaimes. <?php echo date('Y'); ?>">
        <title><?php echo e(env('APP_NAME')); ?> Platform | <?php echo $__env->yieldContent('title'); ?></title>
        <?php echo Html::style('plugins/icheck-bootstrap/icheck-bootstrap.min.css'); ?>          
        <?php echo Html::style('plugins/jqvmap/jqvmap.min.css'); ?>

        <?php echo Html::style('plugins/overlayScrollbars/css/OverlayScrollbars.min.css'); ?>  
        <?php echo Html::style('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css'); ?> 
        <?php echo Html::style('plugins/toastr/toastr.min.css'); ?>          
        <?php echo Html::style('css/adminlte.css'); ?>   
        <?php echo Html::style('plugins/fontawesome-free/css/all.css'); ?>  
    </head>
    <body class="hold-transition login">
            <div class="login-page">  
            <?php echo $__env->yieldContent('content'); ?>
            </div>            
        <footer class="main-footer float-right" style="background: transparent; border-top-color: transparent; float: center">
            <small>&copy; <?php echo e(date('Y',strtotime(now()))); ?> <a href="http://directagroup.net" target="_blank">Directa Group</a>. | Inifity is Powered by Gerencia Ingeniería de Software. Para Soporte Escribanos a <a href="mailto:innovacion@directagroup.net?subject=Soporte Unity DG%20">Innovacion@directagroup.net</a></small>
        </footer>
    </body>
   
    <?php echo Html::script('plugins/jquery/jquery.min.js'); ?>

    <?php echo Html::script('plugins/jquery-ui/jquery-ui.min.js'); ?>  
    <?php echo Html::script('plugins/bootstrap/js/bootstrap.js'); ?>

    <?php echo Html::script('plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>

    <?php echo Html::script('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js'); ?>

    <?php echo Html::script('plugins/jqvmap/jquery.vmap.min.js'); ?>

    <?php echo Html::script('plugins/jquery-validation/jquery.validate.js'); ?>

    <?php echo Html::script('plugins/jquery-validation/localization/messages_es.js'); ?>

    <?php echo Html::script('js/adminlte.js'); ?>

    <?php echo $__env->make('notifications.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</html><?php /**PATH /var/www/html/SISTEMAS_ACTUALIZADOS 8.2/segurosmercantil8/resources/views/layouts/login.blade.php ENDPATH**/ ?>