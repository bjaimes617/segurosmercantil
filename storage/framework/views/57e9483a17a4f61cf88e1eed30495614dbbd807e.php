<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" href="<?php echo e(asset('img/icon.png')); ?>">
        <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
        <meta name="author" content="Deivis Henriquez deivis(at)vozip.net and Braian Jaimes braian.jaimes(at)directagroup.net"/>
        <meta name="copyright" content="Powered by Deivis Henriquez and Braian Jaimes. <?php echo date('Y'); ?>">
        <!-- CSRF Token -->
        <meta name="csrf-token" id="_token" content="<?php echo e(csrf_token()); ?>">
        <title><?php echo e(env('APP_NAME')); ?> - Platform | <?php echo $__env->yieldContent('title'); ?></title>
        <!-- CCS -->
        <?php echo Html::style('plugins/fontawesome-free/css/all.min.css'); ?>                 
        <?php echo Html::style('plugins/jquery-ui/jquery-ui.min.css'); ?>

        <?php echo Html::style('plugins/bootstrap/css/bootstrap.css'); ?>  
        <?php echo Html::style('plugins/jqvmap/jqvmap.min.css'); ?>          
        <?php echo Html::style('plugins/icheck-bootstrap/icheck-bootstrap.min.css'); ?>          
        <?php echo Html::style('plugins/overlayScrollbars/css/OverlayScrollbars.min.css'); ?>  
        <?php echo Html::style('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css'); ?>       
        <?php echo Html::style('plugins/toastr/toastr.min.css'); ?>

        <?php echo $__env->yieldPushContent('styles'); ?>
        <?php echo Html::style('css/adminlte.css'); ?>         
    </head>
    <body class="hold-transition sidebar-mini text-sm">
        <div class="wrapper">            
            <!-- Preloader -->
            <div class="preloader flex-column justify-content-center align-items-center">
                <img class="animation__shake" src="<?php echo e(asset('img/logo directa.png')); ?>" alt="DirectaGroupLogo" height="50" width="90">
            </div>

            <nav class="main-header navbar navbar-expand-md navbar-light navbar-white"><?php echo $__env->make('partials.headers', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></nav>
            <!-- /.navbar -->
            <aside class="main-sidebar sidebar-dark-primary elevation-3">
                <!-- Brand Logo -->
                <a href="<?php echo e(route('home')); ?>" class="brand-link">
                    <img src="<?php echo e(asset('img/LOGO DG DIAPO.png')); ?>" alt="DirectaGroupLogo Logo"  height="55" width="210" style="opacity: .8">                    
                </a>
                <!-- Sidebar -->
                <div class="sidebar"> <?php echo $__env->make('partials.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> </div>
            </aside>  
            <?php echo $__env->yieldContent('content'); ?> 
           <!-- el contect tiene la finalizacion del content wrapper -->
            <?php echo $__env->make('partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </body>        
    <!-- Scripts -->
    <?php echo Html::script('plugins/jquery/jquery.min.js'); ?>    
    <?php echo Html::script('plugins/jquery-ui/jquery-ui.min.js'); ?>

    <?php echo Html::script('plugins/bootstrap/js/bootstrap.js'); ?>

    <?php echo Html::script('plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>      
    <?php echo Html::script('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js'); ?>    
    <?php echo Html::script('plugins/jquery-validation/jquery.validate.js'); ?>

    <?php echo Html::script('plugins/jquery-validation/localization/messages_es.js'); ?>    
    <?php echo Html::script('js/adminlte.js'); ?>   
    <?php echo $__env->make('notifications.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>      
    <?php echo $__env->yieldPushContent('scripts'); ?>    
    
    
</html><?php /**PATH /var/www/html/segurosmercantil/resources/views/layouts/main.blade.php ENDPATH**/ ?>